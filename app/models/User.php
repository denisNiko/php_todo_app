<?php

class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createUser($username, $password, $email) {
        $query = "INSERT INTO " . $this->table . " (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByID($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeToken($user_id, $token){
        $query = "UPDATE " . $this->table . " SET login_token = :token WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }

    public function findByToken($token) {
        $query = "SELECT * FROM " . $this->table . " WHERE login_token = :token LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function clearToken($user_id) {
        $query = "UPDATE " . $this->table . " SET login_token = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }
    public function clearTokenByCookie($token) {
        $query = "UPDATE " . $this->table . " SET login_token = NULL WHERE login_token = :token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    public function verifyLogin($username, $password) {
        $founduser = $this->findByUsername($username);
        if($founduser && password_verify($password, $founduser['password'])) {
            $_SESSION['user_id'] = $founduser['id'];

            if(isset($_POST['remember'])) {
                $token = bin2hex(random_bytes(32));
                $this->storeToken($founduser['id'], $token);
                setcookie('remember_me', $token, time() + (86400 * 30), "/", "", false, false);
            }

            return $founduser;
        }
        return false;
    }
}