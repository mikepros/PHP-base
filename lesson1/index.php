<?php include_once 'functions.php' ?>
<!doctype html>
<html lang="uk">
<head>
    <title>ДЗ №2</title>
</head>
<body>
    <p>
        <b>1. Залежно від суми, витраченої клієнтом, виводяться різні повідомлення:</b><br>
        <?=receipt()?>
    </p>
    <p>
        <b>2. Створити сценарій роботи програми "Розумний дім":</b>
        <?=smartHome(8)?>
    </p>
    <p>
        <b>3. Показати картинку пори року за номером місяця:</b><br>
        <?=showSeasonImg()?>
    </p>
</body>
</html>
