<?php

namespace App\Controllers;

use App\Models\Task;
use function Core\Render\render;

class TaskController
{
    public function index()
    {
        session_start();
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $_SESSION['page'] = $page;
        } else {
            $page = isset($_SESSION['page']) ? $_SESSION['page'] : 1;
        }
        if (isset($_GET['sort'])) {
            $sort = explode(' ', $_GET['sort']);
            $_SESSION['sort'] = $sort;
        } else {
            $sort = isset($_SESSION['sort']) ? $_SESSION['sort'] : ['id', 'desc'];
        }
        $limitPerPage = 3;
        $model = new Task($limitPerPage);
        $tasks = $model->getTasks($page, $sort);
        $totalPages = $model->getTotalPages();
        return render('main', [
            'tasks' => $tasks,
            'totalPages' => $totalPages,
            ]);
    }

    public function create()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model = new Task();
            if($model->addTask($_POST['task'])) {
                $_SESSION['alert'] = "Success";
                http_response_code(301);
                header("Location: /");
            }
        }
        return render('create-task');
    }

    public function update()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model = new Task();
            if($model->updateTask($_GET['id'], $_POST['task'])) {
                $_SESSION['alert'] = "Success";
                http_response_code(301);
                header("Location: /");
            }
        }

        $taskId = $_GET['id'];
        $task = (new Task())->getTask($taskId);
        return render('update-task', ['task' => $task]);
    }
}
