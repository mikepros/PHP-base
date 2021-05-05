<?php include_once 'main.php'?>
<!doctype html>
<html lang="uk">
<head>
    <title>ДЗ №8</title>
    <link rel="stylesheet" href="static/style.css" type="text/css">
    <script type="text/javascript" src="static/ajax.js"></script>
</head>
<body>
    <div>
        <h1>ДЗ №8</h1>
        <ol>
            <li>
                <b>Додати в файловий менеджер панель навігації</b><br>
                <a style="width: 45%;" href="filemanager">Файловий менеджер</a>
            </li>
            <li>
                <b>Замінити в HTML-файлах всі слова "курити" на "займатись спортом", а також вивести на екран всі номери телефонів у заданій теці.</b><br>
                <?=modifyHTMLFiles()?>
            </li>
            <li>
                <b>Написати вікторину на одній сторінці</b><br>
                <a style="width: 45%;" href="quiz">Вікторина</a>
            </li>

        </ol>
    </div>
</body>
</html>