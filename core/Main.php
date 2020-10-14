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
        // $first_name = 
        // if (isset())
    }

    public function formRegister(array $data): void {
        // print_r($data);
        $this->location('/test.html');
        // $first_name = 
        // if (isset())
    }
}

?>