<?php
session_start();

require_once 'app/controllers/TaskController.php';
require_once 'app/controllers/UserController.php';

$taskController = new TaskController();
$userController = new UserController();
$action = $_GET['action'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if(!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $user = $userController->verifyToken($_COOKIE['remember_me']);
    if($user) {
        $_SESSION['user_id'] = $user['id'];
    } else {
        $userController->clearTokenByCookie($_COOKIE['login_token']);
        setcookie('login_token', '', time() - 3600, '/');
    }
}

switch($action) {
    case 'register':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $userController->register($username, $password, $email);
            header("Location: /todo_app_auth/?action=login");
        } else {
            require 'app/views/default/loginHeader.php';
            require 'app/views/register.php';
            require 'app/views/default/footer.php';
        }
        break;
    
    case 'login': 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $userController->login($username, $password);
            if ($user) {
                header("Location: /todo_app_auth");
                exit;
            } else {
                $error = "Invalid username or password";
                require 'app/views/default/loginHeader.php';
                require 'app/views/login.php';
                require 'app/views/default/footer.php';
            }
        } else {
            require 'app/views/default/loginHeader.php';
            require 'app/views/login.php';
            require 'app/views/default/footer.php';
        }
        
        break;

    case 'logout':
        $userController->logout();
        break;

    case 'store':
        if(isset($_SESSION['user_id'])){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $taskController->store($title, $description, $_SESSION['user_id']);
        }
        break;

    case 'delete':
        $id = $_GET['id'];
        $taskController->delete($id);
        break;

    case 'change_status':
        // Handle AJAX request to change task status

        if (isset($_POST['id']) && isset($_POST['status'])) {
            header('Content-Type: application/json');
            $id = $_POST['id'];
            $status = $_POST['status'];
            $taskController->changeStatus($id, $status, $page);
            echo json_encode(['success' => true]);

        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
        }
        exit;

    case 'update':
        $id = $_GET['id'];
        $title = $_POST['title'];
        $descritpion = $_POST['description'];
        $taskController->update($id, $title, $descritpion);
        break;

    default:
        if(isset($_SESSION['user_id'])){
            $tasksPerPage = 10;
            $totalTasks = $taskController->getTotalTasks($_SESSION['user_id']);
            $tasks = $taskController->index($page, $tasksPerPage, $_SESSION['user_id']);
            $totalPages = ceil($totalTasks / $tasksPerPage);
            require 'app/views/default/header.php';
            require 'app/views/index.php';
            require 'app/views/default/footer.php';
        } else {
            header("Location: /todo_app_auth/?action=login");
        }
        break;
}