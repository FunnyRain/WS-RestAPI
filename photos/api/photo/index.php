<?php require_once "../../../autoload.php";

$accept = $_SERVER;
$app = new app;
// if (!isset($accept['HTTP_AUTHORIZATION'])) {
//     $app->sendResponse('403 Forbidden', [ 'message' => 'You need authorization' ]);
//     exit;
// }
if (strtolower($accept['REQUEST_METHOD']) !== 'post') exit;
if (!isset($_FILES)) exit;

$get_name_image = explode('.', $_FILES["fileToUpload"]["name"]);
$type = $get_name_image[count($get_name_image) - 1];
if (in_array($type, ['png','jpg','jpeg'])) {
    $name = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 32) . ".{$type}";
    $file_name = "../../temp/{$name}";
    
    //? Проверка на картинку
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == false) {
        $app->sendResponse('422 Unprocessable entity', [ 'message' => 'File is not image' ]);
        exit;
    }
    //? Проверка на повтор
    if (file_exists($file_name)) {
        $app->sendResponse('422 Unprocessable entity', [ 'message' => 'Sorry, file already exists' ]);
        exit;
    }
    //? Проверка на размер
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $app->sendResponse('422 Unprocessable entity', [ 'message' => 'Sorry, your file is too large' ]);
        exit;
    }
    //* Перемещение из временной директории
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_name)) {
        if (empty($_SESSION['phone'])) return $app->sendResponse('422 Unprocessable entity', [ 'message' => 'You need authorization' ]);
        if (empty($name)) return $app->sendResponse('422 Unprocessable entity', [ 'message' => 'File is not image' ]);

        $db = new db;
        $addPhoto = $db->addPhoto($_SESSION['phone'], $name, "http://" . $accept['HTTP_HOST'] . "/photos/temp/{$name}");
        $app->sendResponse('201 Created', $addPhoto);
    } else {
        $app->sendResponse('422 Unprocessable entity', [ 'message' => 'Photo upload error' ]);
        exit;
    }
} else {
    $app->sendResponse('422 Unprocessable entity', [ 'message' => 'File is not image' ]);
    exit;
}

?>