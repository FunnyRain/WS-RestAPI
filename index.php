<?php require_once 'autoload.php';

$app = new app;
if (!$app->isAuth()) $app->location('/auth/login.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
</head>
<style> body { background-color: #131513; color: #fff; } </style>
<body>
    <h3>
        Ваш токен для запросов: <code style="color: #fff; background-color: #2666f9; border-radius: 15px; padding: 4px; font-size: 95%;">
            <?=$_SESSION['token']?>
        </code>
    </h3>
    <h5>
        <a href="/auth/logout.php">Выйти</a>
    </h5>
</body>

</html>