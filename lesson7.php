<?php declare(strict_types=1);

class Employee {}

interface IEnglish {}

interface IDrive {}

interface IDeveloper {}

class TeamLead extends Employee implements IEnglish, IDrive, IDeveloper {}

class HR extends Employee implements IEnglish, IDrive {}

class Programmer extends Employee implements IEnglish, IDeveloper {}

// Створення 10 екземплярів класів
$employees = [];
            
for ($count = 10; $count--; $employees[] = new $class)
    $class = ['TeamLead', 'HR', 'Programmer'][random_int(0, 2)];
    
// Підрахунок реалізацій інтерфесів
$implementations = ['IENglish' => 0, 'IDrive' => 0, 'IDeveloper' => 0];

foreach ($employees as $object)
    foreach ($implementations as $name => &$number)
        if (is_a($object, $name)) $number++;
unset($number);

// Виведення результату
foreach ($implementations as $name => $number)
    echo "Інтерфейс $name: $number реалізацій<br>\n";