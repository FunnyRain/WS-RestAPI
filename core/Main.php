<?php

session_start();
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
    
    public function formLogin(array $data) {
        $checkPassword = $this->db->checkPassword(
            $data['auth-phone'], 
            $data['auth-password']
        ); 
        if ($checkPassword['status'] == false) {
            $this->sendResponse('422 Unprocessable entity', [
                'error' => $checkPassword['message']
            ]);
        } else {
            $_SESSION['phone'] = $data['auth-phone'];
            $_SESSION['auth'] = true;
            $this->sendResponse('200 OK', [
                'token' => $checkPassword['message']
            ]);
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
            $_SESSION['phone'] = $data['auth-phone'];
            $_SESSION['auth'] = true;
            $this->sendResponse('201 Created', [
                'id' => $addUser['message']
            ]);
        }
        // $this->location('/test.html');
        // $this->sendResponse('201 Created', [
        //     'error' => 'Bad Request'
        // ]);
    }

    public function sendResponse(string $response = "200 OK", array $content = []) {
        header("HTTP/1.1 {$response}");
        if (!empty($content)) echo json_encode($content);
    }
}

?>