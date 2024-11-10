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
        session_destroy();
        header("Location: /todo_app_auth/?action=login");
    } 
}