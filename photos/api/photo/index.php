<?php require_once "../../../autoload.php";

$accept = $_SERVER;
$app = new app;
$db = new db;
// if (!isset($accept['HTTP_AUTHORIZATION'])) {
//     $app->sendResponse('403 Forbidden', [ 'message' => 'You need authorization' ]);
//     exit;
// }
if (strtolower($accept['REQUEST_METHOD']) !== 'post') exit;
if (isset($_POST['_method'])) return editPhoto($_POST, $app, $db);
if (!isset($_FILES)) exit;

if (isset($_FILES["fileToUpload"])) {
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
}

function editPhoto($post, $app, $db) {
    if (strtolower($_POST['_method']) == 'patch') {
        if (empty($_POST['photo']) or empty($_POST['id'])) {
            $app->sendResponse('422 Unprocessable entity', [ 'message' => '{photo/id} is empty' ]);
            exit;
        }
        //? Проверка на редактирование своей фотографии
        $owner_id_By_photo_id = $db->get($_SESSION['phone'], 'owner_id', 'photos', "photo_id='".$_POST['id']."'");
        $owner_id_By_photo_id = !empty($owner_id_By_photo_id) ? $owner_id_By_photo_id : 100000;
        $phone_By_owner_id = $db->get($_SESSION['phone'], 'phone', 'users', "owner_id='{$owner_id_By_photo_id}'");
        if ($phone_By_owner_id == $_SESSION['phone']) {
            // $name = !isset($_POST['name']) ? 'Untitled' : $_POST['name'];
            $photo_name_By_photo_id = $db->get($_SESSION['phone'], 'photo', 'photos', "photo_id='".$_POST['id']."'");
            @file_put_contents("../temp/{$photo_name_By_photo_id}", base64_decode(explode(',', $_POST['photo'])[1]));
            $app->sendResponse('200 OK', [
                'id' => $_POST['id'],
                'name' => $photo_name_By_photo_id,
                'url' => "http://" . $_SERVER['HTTP_HOST'] . "/photos/temp/{$photo_name_By_photo_id}"
            ]);
        } else $app->sendResponse('403 Forbidden', []);
    }
    exit;
}

?>