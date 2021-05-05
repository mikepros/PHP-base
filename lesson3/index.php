<!doctype html>
<html lang="uk">
<head>
    <title>ДЗ №4</title>
    <link rel="stylesheet" href="static/style.css" type="text/css">
    <script type="text/javascript" src="static/ajax.js"></script>
</head>
<body>
    <div>
        <h1>ДЗ №4</h1>
        <ol>
            <li>
                <b>Написати регулярку на введення слова з дефісом.</b>
                <form method="POST">
                    <label for="hyphen">Введіть слово з дефісом</label>
                    <input type="text" id="hyphen" name="hyphen"><input type="submit" value="Відправити">
                </form>
            </li>
            <li>
                <b>Написати регулярку на введення емейла.</b>
                <form method="POST">
                    <label for="email">Введіть емейл</label>
                    <input type="text" id="email" name="email"><input type="submit" value="Відправити">
                </form>
            </li>
            <li>
                <b>Написати регулярку на перевірку числа {1..99999}.</b>
                <form method="POST">
                    <label for="email">Введіть число</label>
                    <input type="text" id="number" name="number"><input type="submit" name="dds" value="Відправити">
                </form>
            </li>
            <li>
                <b>Додати в файловий менеджер функцію перейменування</b><br>
                <a style="width: 45%;" href="filemanager">Файловий менеджер</a>
            </li>
        </ol>
    </div>
</body>
</html>