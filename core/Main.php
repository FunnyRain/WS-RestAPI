<?php

session_start();
date_default_timezone_set('Europe/Moscow');

class app{
    public function __construct() {
        
    }

    public function isAuth() : bool {
        return isset($_SESSION['auth']) ? true : false;
    }

    public function location(string $url = '/'): void {
		header("Location: {$url}");
    }
    
    public function formLogin(array $data): void {
        print_r($data);
    }

    public function formRegister(array $data): void {
        $this->location('/test.html');
        $this->sendResponse('201 Created', [
            'error' => 'Bad Request'
        ]);
    }

    public function sendResponse(string $response = "200 OK", array $content = []) {
        header("HTTP/1.1 {$response}");
        if (!empty($content)) echo json_encode($content);
    }
}

?>