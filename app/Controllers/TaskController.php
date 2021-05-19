<?php

namespace App\Controllers;

use App\Models\Task;
use Core\Controller;

class TaskController extends Controller
{
    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $sort = $_GET['sort'] ?? 'id desc';
        $pageQuery = isset($_GET['page']) ? "page={$_GET['page']}&" : '';
        $sortQuery = isset($_GET['sort']) ? "&sort={$_GET['sort']}" : '';
        $model = new Task();
        $tasks = $model->getTasks($page, $sort);
        $totalPages = $model->getTotalPages();

        return $this->render('main', [
            'tasks' => $tasks,
            'totalPages' => $totalPages,
            'pageQuery' => $pageQuery,
            'sortQuery' => $sortQuery,
            ]
        );
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model = new Task();
            if($model->createTask($_POST['task'])) {
                $this->addFlash('success', 'Task successfully created');
                $this->redirect('/');
            }
        }
        return $this->render('create-task');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model = new Task();
            if($model->updateTask($_GET['id'], $_POST['task'])) {
                $this->addFlash('success', 'Task successfully updated');
                $this->redirect('/');
            }
        }
        $task = (new Task())->getTask($_GET['id']);

        return $this->render('update-task', ['task' => $task]);
    }
}
