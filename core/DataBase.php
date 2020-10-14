<?php 

class db {

    private $db; 

    public function __construct() {
        if (!file_exists('../base.sql')) $this->createTable();

        $this->db = new SQLite3('../base.sql');
    }

    public function createTable() {
        $db = new SQLite3('../base.sql');
        //! users
        $db->exec("CREATE TABLE users (
            owner_id INTEGER PRIMARY KEY, 
            firstname VARCHAR (50) NOT NULL, 
            lastname VARCHAR (50) NOT NULL, 
            phone CHAR(11) NOT NULL CHECK (length(phone) < 12),
            password VARCHAR (50) NOT NULL
        );");
        //! photos
        $db->exec("CREATE TABLE photos (
            owner_id INTEGER, 
            photo VARCHAR (50) NOT NULL, 
            photo_id INTEGER PRIMARY KEY, 
            url VARCHAR(250),
            users TEXT
        );");
    }

    public function addUser(string $firstname, string $lastname, string $phone, string $password) {
        if (empty($firstname) or empty($lastname) or empty($phone) or empty($password)) exit;


    }
}

?>