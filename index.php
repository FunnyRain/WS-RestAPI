<?php 
require_once 'autoload.php';

$app = new app;
if (!$app->isAuth()) $app->location('/auth/login.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>

<body>
    <form method="post" action="index.php">
        <input type="text" pattern="\d*" name="auth-phone" placeholder="799999999999">
        <input type="password" name="auth-password" placeholder="******">
        <button type="submit">Войти</button>
    </form>
</body>

</html>