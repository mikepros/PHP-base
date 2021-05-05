<?php

function modifyHTMLFiles() : string
{
    $phones = [];
    $count_of_occurrences = 0;
    $dir = './test/html';
    $search = 'курити';
    $replace = 'займатися спортом';
    $phone_pattern = '/\+38-0\d{2}-\d{3}-\d{2}-\d{2}/';

    // Отримую список усіх файлів із закінченням .html
    $html_files = rsearch($dir, "/.*\.html$/");

    foreach($html_files as $file) {
        // Отримую вміст файлу
        $content = file_get_contents($file);

        // Виконую заміну
        $content = str_ireplace($search, $replace, $content, $count);
        file_put_contents($file, $content);

        // Знаходжу всі номени
        preg_match_all($phone_pattern, $content,$matches, PREG_PATTERN_ORDER);
        array_push($phones, ...$matches[0]);
        $count_of_occurrences += $count;
    }

    // І повертаю результат
    $result = "Кількість замінених слів \"$search\": $count_of_occurrences<br>Знайдені номери: <br>";
    foreach (array_filter($phones) as $phone) $result .= "$phone<br>";

    return $result;
}


/**
 * Повертає шляхи до всіх вкладених файлів і тек відповідно до regex-шаблону
 * @param $folder  - Тека, в якій треба шукати
 * @param $pattern - regex-шаблон
 * @return array
 */
function rsearch($folder, $pattern) :array
{
    $dir = new RecursiveDirectoryIterator($folder);
    $ite = new RecursiveIteratorIterator($dir);
    $files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
    $fileList = array();
    foreach($files as $file) {
        $fileList = array_merge($fileList, $file);
    }
    return $fileList;
}
