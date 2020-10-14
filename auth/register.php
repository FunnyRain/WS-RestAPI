<?php
require_once "../autoload.php";

$app = new app;
if ($app->isAuth()) $app->location();
if (!empty($_POST)) $app->formRegister($_POST);
print_r($_POST);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>

<body>
    <form method="post" action="register.php">
        <input type="text" name="auth-firstname" placeholder="Имя"><br>
        <input type="text" name="auth-lastname" placeholder="Фамилия"><br>
        <input type="text" pattern="\d*" name="auth-phone" placeholder="+799999999999"><br>
        <input type="password" name="auth-password" placeholder="******"><br>
        <button type="submit">Продолжить</button>
        <br>Уже есть аккаунт? <a href="/auth/login.php">Войти</a>
    </form>
</body>

</html>