<?php
// Для того, щоби зберігати прогрес вікторини для конкретного користувача,
// застосовано вбудований в PHP механізм "сесій"
session_start();

$questions = [
    'question1' => ['title' => '2 + 2 = ?', 'answers' => ['correct' => '4', '22', '0']],
    'question2' => ['title' => '3 + 3 = ?', 'answers' => ['correct' => '6', '7', '8']],
    'question3' => ['title' => '4 + 4 = ?', 'answers' => ['correct' => '8', '3', '11', '16']]
];

if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
<!doctype html>
<html lang="uk">
<head>
    <title>Вікторина</title>
    <link rel="stylesheet" href="static/style.css" type="text/css">
    <script src="static/ajax.js"></script>
</head>
<body>
    <div class="center">
        <h1>Вікторина</h1>
        <div id="page"><?=currentPage()?></div>
        <a href="../" style="padding: 0"><b>На головну</b></a>
    </div>
</body>
</html>
<?php
elseif ($_SERVER['REQUEST_METHOD'] === 'POST'):
    echo json_encode(
        empty($_POST) ?                                   // Якщо кнопка була натиснута, але відповідь не обрана —
            ['.error' => ['innerHTML' => "Оберіть відповідь!" , 'className' => 'error disappear']] // повідомити про це.
            :                                                   // В іншому випадку —
            ['#page' => ['innerHTML' => currentPage()]]);       // показати наступе питання.
endif;

function currentPage() :string
{

    setProgress();

    return getPageContent();

}

function setProgress() :void
{
    global $questions;

    // Якщо ви вперше на сторінці, вам буде показано перше питання
    if (!isset($_SESSION['form_id']))
        $_SESSION['form_id'] = array_key_first($questions);

    // Якщо отримана відповідь
    if (isset($_POST[$_SESSION['form_id']])):
        // Записую її в сесію
        $_SESSION['answers'][$_SESSION['form_id']] = $_POST[$_SESSION['form_id']];

        // Зміщую вказівник масиву на наступне питання
        do ($question = key($questions)) and next($questions); while ($question !== $_SESSION['form_id'] and current($questions));

        // Встановлюю це питання для відображення
        $_SESSION['form_id'] = key($questions);
    endif;
}

function getPageContent() : string
{
    global $questions;

    $html_page = '';

    //Виводжу поточне питання
    if ($_SESSION['form_id'] !== null):

        $answers = $questions[$_SESSION['form_id']]['answers'];
        $title = $questions[$_SESSION['form_id']]['title'];
        shuffle($answers);

        $html_page .= "<h2>$title</h2><form class='' method=\"POST\">";

        foreach ($answers as $id => $answer)
            $html_page .= "<input type=\"radio\" name=\"${_SESSION['form_id']}\" id=\"l$id\" value=\"$answer\">" .
                "<label for=\"l$id\">$answer</label><br>";

        $html_page .= '<input type="submit" value="Далі"><span class="error"></span></form>';

    // Якщо питання закінчились, показую результат
    else:
        $html_page = '<h2>Результат:</h2><br><ul>';

        foreach ($questions as $id => $data):
            $answer = $_SESSION['answers'][$id];
            $is_correct = array_search($answer, $data['answers']) === 'correct';

            $html_page .= "<li><b>${data['title']}</b><br><span class=\"".
                ($is_correct ?
                    "success\"> <i>$answer</i> - відповідь правильна!":
                    "error\">Отримана відповідь: <i>$answer</i>. Правильна відповідь: <i>" . $data['answers']['correct'] . '</i>.')
                .'</span></li><br>';
        endforeach;

        $html_page .= '</ul>';

        // Завершую сесію
        session_destroy();
    endif;

    // Виводжу сформовану сторінку
    return $html_page;
}