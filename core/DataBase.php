<?php 

class db {

    public $db; 

    public function __construct() {
        if (!file_exists(config::get['db_path'].'/'.config::get['db_name'])) $this->createTable();

        $this->db = new SQLite3(config::get['db_path'].'/'.config::get['db_name']);
    }

    public function createTable() {
        $db = new SQLite3(config::get['db_path'].'/'.config::get['db_name']);
        //! users
        $db->exec("CREATE TABLE users (
            owner_id INTEGER PRIMARY KEY, 
            firstname VARCHAR (50) NOT NULL, 
            lastname VARCHAR (50) NOT NULL, 
            phone CHAR(11) NOT NULL CHECK (length(phone) < 12),
            password VARCHAR (50) NOT NULL,
            token TEXT
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

    public function existsPhone(string $phone): bool {
        if(!$this->db->query("SELECT * FROM users WHERE phone = '{$phone}'")->fetchArray(SQLITE3_ASSOC)) {
            return false;
        } else {
            return true;
        }
    }

    public function set(string $phone, string $var, $value, string $base = "users") {
        if (empty($phone) or empty($var) or empty($base)) exit;
        $this->db->query("UPDATE {$base} SET {$var} = '{$value}' WHERE phone = '{$phone}'");
        $this->db->close();
    }

    public function get(string $phone, string $var = "*", string $base = "users", $d = null) {
        if (empty($phone) or empty($var) or empty($base)) exit;
    if ($d !== null) return $this->db->query("SELECT {$var} FROM {$base} WHERE {$d}")->fetchArray()[$var];
        return $this->db->query("SELECT {$var} FROM {$base} WHERE phone = '{$phone}'")->fetchArray()[$var];
    }

    public function checkPassword(string $phone, string $password) {
        if (empty($phone)) return ['status' => false, 'message' => 'пустая строка phone'];
        if (!is_numeric($phone)) return ['status' => false, 'message' => 'номер должен быть цифровой'];
        if (strlen($phone) >= 12) return ['status' => false, 'message' => 'длина номера должна быть меньше 11 символов!'];
        if (empty($password)) return ['status' => false, 'message' => 'пустая строка password'];

        if ($password === $this->get($phone, 'password')) {
            // d
            $generateToken = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 64);
            $this->set(
                $phone, 
                'token', 
                $generateToken
            );
            return ['status' => true, 'message' => $generateToken];
        } else return ['status' => false, 'code' => 404, 'message' => 'неправильный пароль'];
    }

    public function addUser(string $firstname, string $lastname, string $phone, string $password) {
        if (empty($firstname)) return ['status' => false, 'message' => 'пустая строка firstname'];
        if (empty($lastname)) return ['status' => false, 'message' => 'пустая строка lastname'];
        if (empty($phone)) return ['status' => false, 'message' => 'пустая строка phone'];
        if (!is_numeric($phone)) return ['status' => false, 'message' => 'номер должен быть цифровой'];
        if (strlen($phone) >= 12) return ['status' => false, 'message' => 'длина номера должна быть меньше 11 символов!'];
        if (empty($password)) return ['status' => false, 'message' => 'пустая строка password'];

        if ($this->existsPhone($phone)) return ['status' => false, 'message' => 'аккаунт с таким номером уже существует'];

        $this->db->exec("INSERT INTO users (
            'firstname', 
            'lastname',
            'phone',
            'password'
        ) VALUES (
            '{$firstname}',
            '{$lastname}',
            '{$phone}',
            '{$password}'
        );");
        $id = $this->db->query("SELECT owner_id FROM users WHERE 
            firstname='{$firstname}' AND 
            lastname='{$lastname}' AND 
            phone='{$phone}' AND 
            password='{$password}'
        ")->fetchArray();
        $this->db->close();
        return !empty($id) ? ['status' => true, 'message' => $id['owner_id']] : ['status' => false, 'message' => 'ошибка'];
    }

    public function addPhoto(string $phone, string $file_name, string $url) {
        $owner_id = $this->get($phone, 'owner_id');
        $owner_id = !empty($owner_id) ? $owner_id : 100000;
        $this->db->exec("INSERT INTO photos (
            'owner_id', 
            'photo',
            'url',
            'users'
        ) VALUES (
            '{$owner_id}',
            '{$file_name}',
            '{$url}',
            ''
        );
        ");
        $photo_id = $this->get($phone, 'photo_id', 'photos', "photo='{$file_name}'");
        $photo_id = !empty($photo_id) ? $photo_id : mt_rand(1,10000000);
        $this->db->close();
        return [
            'id' => $photo_id,
            'name' => $file_name,
            'url' => $url  
        ];
    }
}

?>