<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Якщо запит до цього файлу виконано методом PUSH
    switch (key($_POST)) { // Залежно від отриманої форми
        case 'hyphen': hyphenCheck($_POST['hyphen']); break; // Перевіряю на слово з дефісом
        case 'email': emailCheck($_POST['email']); break; // Перевіряю чи валідний емейл
        case 'number': numberCheck($_POST['number']); break; // Перевіряю чи введено число від 1 до 99999
    }

}

function hyphenCheck($data) : void
{
    // Ініціалізую regex-шаблон
    $pattern = '/^\w+\-\w+$/';

    // Перевіряю співпадіння введених даних з шаблоном
    if (preg_match($pattern, $data))
        $result = ['state' => 'success', 'text' => 'Введено слово з дефісом'];
    else
        $result = ['state' => 'error', 'text' => 'Це не слово з дефісом'];

    // І надсилаю json-відповідь залежно від результату preg_match
    echo json_encode($result);
}

function emailCheck($data) : void
{
    $pattern = '/^.+@.+\.com$/';
    if (preg_match($pattern, $data))
        $result = ['state' => 'success', 'text' => 'Емейл валідний'];
    else
        $result = ['state' => 'error', 'text' => 'Це не емейл'];
    echo json_encode($result);
}

function numberCheck($data) : void
{
    $pattern = '/^(?!0)\d{1,5}$/';
    if (preg_match($pattern, $data))
        $result = ['state' => 'success', 'text' => 'Число в діапазоні від 1 до 99999'];
    else
        $result = ['state' => 'error', 'text' => 'Це не число в діапазоні від 1 до 99999'];
    echo json_encode($result);
}
