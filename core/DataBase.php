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

    public function get(string $phone, string $var = "*", string $base = "users") {
        if (empty($phone) or empty($var) or empty($base)) exit;
        return $this->db->query("SELECT {$var} FROM users WHERE phone = '{$phone}'")->fetchArray()[$var];
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

        $this->db->query("INSERT INTO users (
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
}

?>