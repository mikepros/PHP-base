<?php

function receipt (int $spent = 10100, bool $is_deputy = false): string
{
    if ($spent > 100000) return 'Витрачено більше ста тисяч.';
    elseif ($spent < 100000 && $spent > 80000) return 'Витрачено від 80000 до 100000.';
    if ($spent < 80000 && $spent > 60000 || $is_deputy) return 'Витрачено від 60000 до 80000 або клієнт — депутат.';
    else return 'Витрачено менше 60 тисяч';
}

function smartHome (int $program = 4): string
{
    $programs = [
        ['Відправляю повідомлення в охоронну службу',
         'Відправляю повідомлення власнику будинку',
         'Запускаю робота-машину "ЗЛИЙ ПЕС"'],

        ['Вимикаю світло',
         'Вимикаю кондиціонер',
         'Зачиняю всі вікна та двері',
         'Ставлю будинок на сигналізацію'],

        ['Знімаю сигналізацію з будинку',
         'Вмикаю кондиціонер',
         'Вмикаю кавоварку'],

        ['Запускаю робота-порохотяга',
         'Запускаю пральну машину',
         'Запускаю посудомийку']
    ];
    $programs[8] = &$programs[3];
    $message = "<ul>\n";

    foreach(
        array_key_exists($program, $programs)?
            $programs[$program] : $programs[0]
            as $action
    )
        $message .= "            <li>$action</li>\n";

    return $message."        </ul>\n";

}

function showSeasonImg (int $month = 2) : string
{
    $message = '<img src="static/';

    switch ($month) {
        case 12: case 1: case 2:
            $message .= 'winter';
            break;
        case 3: case 4: case 5:
            $message .= 'spring';
            break;
        case 6: case 7: case 8:
            $message .= 'summer';
            break;
        case 9: case 10: case 11:
        $message .= 'autumn';
        break;
        default:
            return "Немає $month-го місяця";
    }

    return $message . ".png\">\n";
}