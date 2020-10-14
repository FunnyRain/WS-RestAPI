<?php require_once "../../autoload.php";

$accept = $_SERVER;
$app = new app;
if (!isset($accept['HTTP_AUTHORIZATION'])) {
    $app->sendResponse('403 Forbidden', [ 'message' => 'You need authorization' ]);
    exit;
}
/**
Array (
    [DOCUMENT_ROOT] => /home/vyxel/Рабочий стол/GitHub projects/WS-RestAPI
    [REMOTE_ADDR] => 127.0.0.1
    [REMOTE_PORT] => 38970
    [SERVER_SOFTWARE] => PHP 7.4.11 Development Server
    [SERVER_PROTOCOL] => HTTP/1.1
    [SERVER_NAME] => localhost
    [SERVER_PORT] => 8080
    [REQUEST_URI] => /photos/api
//?    [REQUEST_METHOD] => POST
    [SCRIPT_NAME] => /photos/api/index.php
    [SCRIPT_FILENAME] => /home/vyxel/Рабочий стол/GitHub projects/WS-RestAPI/photos/api/index.php
    [PHP_SELF] => /photos/api/index.php
    [HTTP_HOST] => localhost:8080
    [HTTP_USER_AGENT] => Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0
    [HTTP_ACCEPT] => --
    [HTTP_ACCEPT_LANGUAGE] => ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
    [HTTP_ACCEPT_ENCODING] => gzip, deflate
//?    [HTTP_AUTHORIZATION] => Bearer 907c762e069589c2cd2a229cdae7b8778caa9f07
    [HTTP_ORIGIN] => moz-extension://4754dd0b-ca82-4a20-ba9d-3dffdc033042
    [HTTP_CONNECTION] => keep-alive
    [HTTP_COOKIE] => PHPSESSID=l3nmpddosvhl855sm2uvp94eim
    [CONTENT_LENGTH] => 0
    [HTTP_CONTENT_LENGTH] => 0
    [REQUEST_TIME_FLOAT] => 1602691757.9838
    [REQUEST_TIME] => 1602691757
)
 */

print_r($_SERVER);

?>