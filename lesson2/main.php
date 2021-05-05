<?php
include_once 'common.php';
ini_set("serialize_precision", -1); //Щоб PHP при серіалізації не додавав знаки після коми для float

$books = [
    ['Name' => 'Цифрова фортеця', 'Author' => 'Ден Браун', 'Genre' => 'Детектив', 'Price' => 200],
    ['Name' => 'Айвенго', 'Author' => 'Вальтер Скотт', 'Genre' => 'Історичний роман', 'Price' => 600],
    ['Name' => 'Доктор Сон', 'Author' => 'Стівен Кінг', 'Genre' => 'Жахи', 'Price' => 250],
    ['Name' => 'Алхімік', 'Author' => 'Пауло Коельйо', 'Genre' => 'Роман', 'Price' => 130],
    ['Name' => 'Чорний ворон. Залишенець', 'Author' => 'Василь Шкляр', 'Genre' => 'Історичний роман', 'Price' => 160]
];

function outputStars(): string
{
    // Створюю масив з 10 випадкових чисел {-5..10}
    $array = generate_array(fn()=>random_int(-5, 10), 10);
    // Записую його в результат
    $message = '<br>Масив: ' . json_encode($array) . '<br><ul>';

    // За допомогою циклу додаю до результату HTML-список з зірочками відповідно до значень масиву
    foreach ($array as $number) {
        $message .= '<li>' .
            (($number < 0) ?
                'Від\'ємна кількість' :
                '<span style="white-space: nowrap;">' . str_repeat('*', $number) . "</span>")
            . '</li>';
    }

    return $message . '</ul>';
}


function splitArray() : string
{
    //Генерація основного масиву
    $random_value = fn()=> [random_int(1,100), random_int(1,10000)/100, str_shuffle('abcd')][random_int(0, 2)];
    $array = generate_array($random_value,20);

    // Розділення
    $ints = array_values(array_filter($array, 'is_int'));
    $floats = array_values(array_filter($array, 'is_float'));
    $strings = array_values(array_filter($array, 'is_string'));

    // Виведення
    return '<br>Основний масив: ' . json_encode($array) . '<br>' .
        'Лише цілі числа: ' . json_encode($ints) .  '<br>' .
        'Лише дійсні: ' . json_encode($floats) .  '<br>' .
        'Лише рядки: ' . json_encode($strings);
}


function manageBooks() : string
{
    global $books;

    // Перетворюю масив у HTML-таблицю, записую в результат
    $result = arrayToTable($books) . '<br>';

    $result .=  'Підвищую ціну історичних книг на 20%';
    // Проходжусь по масиву,
    // збільшую "Price" на 20%, якщо елемент "Genre" має значення "історичний роман"
    array_walk($books, function (&$book) {
        if($book['Genre'] === 'Історичний роман') $book['Price'] *= 1.2;
    });
    // додаю до результату змінений масив
    $result .= arrayToTable($books). '<br>';

    // Відокремлюю детективи в окремий масив
    $detectives = array_filter($books, fn($book)=> $book['Genre'] === 'Детектив');
    // Додаю до результату
    $result .= 'Лише детективи:'. arrayToTable($detectives);

    //Повертаю результат виконання функції
    return $result;
}


function getGenresSummary() : string {
    // Повторне використання масиву з книгами
    global $books;

    $genresSummary = [];

    // Заповнення масиву $genresSummary
    array_walk($books, function ($book) use (&$genresSummary) {
        // Створення елемента (якщо такого ще немає) з ключем, який дорівнює значенню елемента 'Genre' з вкладеного масиву,
        // та зі значенням - 0.
        if(!isset($genresSummary[$book['Genre']]))
            $genresSummary[$book['Genre']] = 0;
        // Сумування значень елементів "Price" з вкладених масивів, у яких спільний елемент "Genre";
        $genresSummary[$book['Genre']] += $book['Price'];
    });

    // Виведення масиву, як таблиці
    return arrayToTable($genresSummary);
}


function arrayToSelect() :string
{
    // Ініціалізую масив з країнами, містами та брендами
    $array = [
        'Countries' => ['Україна', 'Грузія', 'Молдова', 'Білорусь'],
        'Cities' => ['Київ', 'Львів', 'Полтава', 'Дніпро'],
        'Brands' => ['Nike', 'Adidas', 'Puma', 'Reebok']
        ];

    // Додаю його до результату, перетворивши спершу в таблицю
    $result =  '<br>Масив: ' . arrayToTable($array) . '<br>' .
        '<label for="ccb">Випадаючий список:</label>
         <select name="ccb">';

    // Додаю та групую опції випадаючого списку
    foreach ($array as $label => $list) {
        $result .=
            "<optgroup label=\"$label\">" .
            array_reduce($list, function ($html, $text) {
                $html .= "<option value=\"$text\">$text</option>"; return $html;
            }) .
            "</optgroup>";
    }

    //Повертаю результат виконання функції
    return $result . '</select>';
}


function check() : string
{
    // Масив з покупцями
    $costumers = [
        ['name' => 'Tom', 'wallet' => 30],
        ['name' => 'Carl', 'wallet' => 5],
        ['name' => 'Marry', 'wallet' => 10]
    ];

    // Масив з товарами
    $goods = [
        ['name' => 'bread', 'price' => 3],
        ['name' => 'beer', 'price' => 5],
        ['name' => 'sausage', 'price' => 19]
    ];

    // Додавання масивів до результату
    $result = '<br>Покупці:' . arrayToTable($costumers) .
              '<br>Товари:' . arrayToTable($goods) . '<br>';

    foreach ($costumers as $costumer) {
        $sum = 0;
        $result .= "Покупець <i>${costumer['name']}</i> купив";
        foreach ($goods as $item) {
            if($item['price'] > $costumer['wallet']) break; // Якщо ціна товару менша, аніж кількість грошей у гаманці - завершити покупки

            $sum += $item['price']; // Вирахування суми
            $costumer['wallet'] -= $item['price']; // Дебіт
            $result .= " <i>${item['name']}</i>,"; // Виведення товару
        }
        $result[strlen($result) -1] = '.'; // Заміна коми на крапку
        $result .= " Загальна вартість — <i>$sum</i>.<br>"; // Виведення суми
    }

    return $result;
}


/**
 * Перетворює певні види масивів на HTML-таблиці
 * 1) [ key => value, ...]
 * 2) [ key => [ value, ...], ...]
 * 3) [ [ key => value, ...], ...]
 * @param array $array
 * @return string
 */
function arrayToTable(array $array) : string
{
    $rows = [];
    $table = '<table>';

    // Визначення назв колонок та перетворення даного масиву на масив рядків — [ [col_n, ...], ...]
    if (!is_string(array_key_first($array)) && is_array(current($array))) { // Якщо заголовки - це ключі вкладеного масиву
        $headers = array_keys(current($array));
        $rows = $array;
    }
    else  { // Якщо заголовки - це ключі основного масиву
        $headers = array_keys($array);

        if(is_array(current($array))) { // Якщо під заголовком допускається велика кількість значень [ заголовок => [значення, ...], ...]
            $max = count(max(array_values($array)));

            for($i = 0; $i < count($headers); $i++)
            for ($j = 0; $j < $max; $j++) {
                $rows[$j][] = isset($array[$headers[$i]][$j]) ? $array[$headers[$i]][$j] : '';
            }
        }
        else $rows[] = array_values($array); // Якщо під заголовком допускається лише одне значення [заголовок => значення, ...]
    }

    if(isset($headers)) { // Якщо визначено заголовки
        // Додавання їх до першого рядка таблиці
        $table .= '<tr>';
        foreach ($headers as $header)
            $table .= "<th>$header</th>";
        $table .= '</tr>';
    }

    foreach ($rows as $row) {
        $table .= '<tr>';
        foreach ($row as $col) {
            $table .= "<td>$col</td>";
        }
        $table .= '</tr>';
    }
    $table .= '</table>';

    return $table;
}