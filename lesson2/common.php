<?php

/**
 * Створює масив відповідно до шаблону
 * @param callable $value
 * Значення, що поверне ця функція, матиме кожен елемент масиву
 * @param int|array ...$pattern
 * Числа (вказують скільки значень треба створити) або масиви
 * Напр. 3 => [$value(), $value(), $value()]
 *       1,2 => [$value(), $value(), $value()]
 *       1,[1,[1]],1 => [$value(), [$value(),[$value()]], $value()]
 *       [3] => [[$value(), $value(), $value()]]
 * @return array
 */

function generate_array (callable $value, int|array ...$pattern) : array
{
    $new_array = [];

    foreach ($pattern as $item)
        if (is_int($item))
            while (--$item >= 0) $new_array[] = $value(); // Заповнення масиву значеннями
        else
            $new_array[] = generate_array($value, ...$item); // Створення вкладеного масиву, якщо вказано

    return $new_array;
}


/**
 * Форматує відступи в HTML-коді перед виводом на екран
 * @link https://github.com/gajus/dindent оригінальний код
 * @license https://github.com/gajus/dindent/blob/master/LICENSE BSD 3-Clause
 * @param string $input
 * @return string
 */
function outputHandler(string $input) :string
{
    $indent = '    ';
    $inline_elements = ['b', 'i', 'small', 'abbr', 'acronym', 'cite', 'code', 'dfn', 'em', 'kbd', 'strong', 'samp', 'var', 'a', 'bdo', 'br', 'img', 'span', 'sub', 'sup'];
    $temporary_replacements_script =
    $temporary_replacements_inline = [];
    $output = '';
    $next_line_indentation_level = 0;

    if (preg_match_all('/<script\b[^>]*>([\s\S]*?)<\/script>/mi', $input, $matches)) {
        $temporary_replacements_script = $matches[0];

        foreach ($matches[0] as $i => $match)
            $input = str_replace($match, '<script>' . ($i + 1) . '</script>', $input);
    }

    // Removing double whitespaces to make the source code easier to read.
    // With exception of <pre>/ CSS white-space changing the default behaviour, double whitespace is meaningless in HTML output.
    $input = str_replace("\t", '', $input);
    $input = preg_replace('/\s{2,}/u', ' ', $input);

    // Remove inline elements and replace them with text entities.
    if (preg_match_all('/<(' . implode('|', $inline_elements) . ')[^>]*>(?:[^<]*)<\/\1>/', $input, $matches)) {
        $temporary_replacements_inline = $matches[0];

        foreach ($matches[0] as $i => $match)
            $input = str_replace($match, 'ᐃ' . ($i + 1) . 'ᐃ', $input);
    }

    $subject = $input;

    do {
        $indentation_level = $next_line_indentation_level;

        $patterns = [
            // block tag
            '/^(<([a-z]+)(?:[^>]*)>(?:[^<]*)<\/(?:\2)>)/' => 'MATCH_INDENT_NO',
            // DOCTYPE
            '/^<!([^>]*)>/' => 'MATCH_INDENT_NO',
            // tag with implied closing
            '/^<(input|link|meta|base|br|img|source|hr)([^>]*)>/' => 'MATCH_INDENT_NO',
            // self closing SVG tags
            '/^<(animate|stop|path|circle|line|polyline|rect|use)([^>]*)\/>/' => 'MATCH_INDENT_NO',
            // opening tag
            '/^<[^\/]([^>]*)>/' => 'MATCH_INDENT_INCREASE',
            // closing tag
            '/^<\/([^>]*)>/' => 'MATCH_INDENT_DECREASE',
            // self-closing tag
            '/^<(.+)\/>/' => 'MATCH_INDENT_DECREASE',
            // whitespace
            '/^(\s+)/' => 'MATCH_DISCARD',
            // text node
            '/([^<]+)/' => 'MATCH_INDENT_NO'
        ];

        foreach ($patterns as $pattern => $rule) {
            if ($match = preg_match($pattern, $subject, $matches)) {

                $subject = mb_substr($subject, mb_strlen($matches[0]));

                if ($rule === 'MATCH_DISCARD') break;

                if ($rule !== 'MATCH_INDENT_NO') {
                    if ($rule === 'MATCH_INDENT_DECREASE') {
                        $next_line_indentation_level--;
                        $indentation_level--;
                    }
                    else $next_line_indentation_level++;
                }

                if ($indentation_level < 0) $indentation_level = 0;

                $output .= str_repeat($indent, $indentation_level) . $matches[0] . "\n";

                break;
            }
        }
    } while ($match);

    $output = preg_replace('/(<(\w+)[^>]*>)\s*(<\/\2>)/u', '\\1\\3', $output);

    foreach ($temporary_replacements_script as $i => $original)
        $output = str_replace('<script>' . ($i + 1) . '</script>', $original, $output);

    foreach ($temporary_replacements_inline as $i => $original)
        $output = str_replace('ᐃ' . ($i + 1) . 'ᐃ', $original, $output);

    return trim($output);
}

ob_start('outputHandler');