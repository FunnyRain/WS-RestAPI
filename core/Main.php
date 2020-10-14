<?php

session_start();
ini_set('file_uploads', 1);
date_default_timezone_set('Europe/Moscow');

class app{

    private $db;

    public function __construct() {
        $this->db = new db;
    }

    public function isAuth() : bool {
        return isset($_SESSION['auth']) ? true : false;
    }

    public function location(string $url = '/'): void {
		header("Location: {$url}");
    }

    public function uploadImage($data) {
        // print_r($data);
        // $target_file = "../photos/temp/" . basename($_FILES["fileToUpload"]["name"]);
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // print_r($data);
        // print_r($imageFileType);
        // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        // if($check !== false) {
        //     echo "File is an image - " . $check["mime"] . ".";
        // } else {
        //     echo "File is not an image.";
        // }
    }
    
    public function formLogin(array $data) {
        $checkPassword = $this->db->checkPassword(
            $data['auth-phone'], 
            $data['auth-password']
        ); 
        if ($checkPassword['status'] == false) {
            if (isset($checkPassword['code']) and $checkPassword['code'] == 404) {
                $this->sendResponse('404 Not found', [
                    'login' => 'Incorrect login or password'
                ]);
            } else {
                $this->sendResponse('422 Unprocessable entity', [
                    'error' => $checkPassword['message']
                ]);
            }
        } else {
            $_SESSION['phone'] = $data['auth-phone'];
            $_SESSION['auth'] = true;
            $_SESSION['token'] = $checkPassword['message'];
            $this->sendResponse('200 OK', [
                'token' => $checkPassword['message']
            ]);
            $this->location();
        }
    }

    public function formRegister(array $data): void {
        $addUser = $this->db->addUser(
            $data['auth-firstname'], 
            $data['auth-lastname'], 
            $data['auth-phone'], 
            $data['auth-password']
        );
        if ($addUser['status'] == false) {
            $this->sendResponse('422 Unprocessable entity', [
                'error' => $addUser['message']
            ]);
        } else {
            // $_SESSION['phone'] = $data['auth-phone'];
            // $_SESSION['auth'] = true;
            $this->sendResponse('201 Created', [
                'id' => $addUser['message']
            ]);
            echo '<script> alert("авторизуйтесь для продолжения") </script>';
            $this->location('/auth/login.php');
        }
    }

    public function sendResponse(string $response = "200 OK", array $content = []) {
        header("HTTP/1.1 {$response}");
        if (!empty($content)) echo json_encode($content);
    }
}

?>