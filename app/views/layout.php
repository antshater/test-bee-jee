<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Задачник</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
            integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
            crossorigin="anonymous"
    >
    <link
            rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
            integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
            crossorigin="anonymous"
    >
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="/">Задачник</a>
    <? if (\Core\Auth::isAdmin()): ?>
        <a class="nav justify-content-end" href="/logout">Выйти</a>
    <? else: ?>
        <a class="nav justify-content-end" href="/login">Войти</a>
    <? endif; ?>
</nav>
<div class="container">
    <?= $content ?>
</div>
<?= \Core\App::jsBlock() ?>
</body>
</html>
