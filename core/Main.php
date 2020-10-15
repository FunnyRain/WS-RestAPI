<?php

session_start();
ini_set('file_uploads', 'On');
ini_set('display_errors', true);
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

    public function uploadImage($FILES, $POST) {
        
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
            // $_SESSION['id'] = $addUser['message'];
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