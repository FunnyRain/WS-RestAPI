<?php
require_once "../autoload.php";

$app = new app;
if ($app->isAuth()) $app->location();

// $app->
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<style> body { background-color: #131513; color: #fff; } </style>
<body>
    <form method="post" action="login.php">
        <input type="text" pattern="\d*" name="auth-phone" placeholder="+799999999999"><br>
        <input type="password" name="auth-password" placeholder="******"><br>
        <button type="submit">Продолжить</button>
        <br>Нет аккаунта? <a href="/auth/register.php">Зарегистрироваться</a>
    </form>
</body>

</html>