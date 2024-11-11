<?php
require_once 'app/models/User.php';

class UserController {
    private $user;
    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->user = new User($db);
    }

    public function register($username, $password, $email){
        return $this->user->createUser($username, $password, $email);
    }

    public function login($username, $password) {
        return $this->user->verifyLogin($username, $password);
    }

    public function logout() {
        session_unset();
        session_destroy();

        if(isset($_COOKIE['remember_me'])){
            setcookie('remember_me', '', time() - 3600, "/");
            $this->user->clearToken($_SESSION['user_id']);
        }
        header("Location: /todo_app_auth/?action=login");
    } 

    public function verifyToken($token) {
        return $this->user->findByToken($token);
    }

    public function clearToken($user_id) {
        return $this->user->clearToken($user_id);
    }

    public function clearTokenByCookie($token) {
        return $this->user->clearTokenByCookie($token);
    }
}