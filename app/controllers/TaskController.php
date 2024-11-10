<?php
require_once 'config/database.php';
require_once 'app/models/Task.php';

class TaskController {
    private $task;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->task = new Task($db);
    }

    public function index($page = 1, $taskPerPage = 10, $user_id) {
        return $this->task->getTasksByPage($page, $taskPerPage, $user_id);
    }

    public function getTotalTasks($user_id) {
        return $this->task->getTotalTasks($user_id);
    }

    public function store($title, $description, $user_id){
        $this->task->create($title, $description, $user_id);
        header("Location: /todo_app_auth/");
    }

    public function delete($id) {
        $this->task->delete($id);
        header("Location: /todo_app_auth/");
    }

    public function changeStatus($id, $status, $page) {
        $this->task->updateStatus($id, $status);
        header('Content-Type: application/json');
        //header("Location: /todo_app_auth?page=$page");
    }

    public function update($id, $title, $description) {
        $this->task->updateTask($id, $title, $description);
        header("Location: /todo_app_auth/");
    }
}