<?php require_once "../autoload.php";

session_destroy();
$app = new app;
$app->location();