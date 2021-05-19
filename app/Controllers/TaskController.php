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
        $perPageLimit = 3;
        $tasks = Task::getTasks($page, $sort, $perPageLimit);
        $totalTasks = Task::getTasksCount();
        $totalPages = ceil($totalTasks / $perPageLimit);

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
        $model = new Task();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if($model->createTask($_POST['task'])) {
                $this->addFlash('success', 'Task successfully created');
                $this->redirect('/');
            }
        }

        return $this->render('create-task', [
            'model' => $model,
        ]);
    }

    public function update()
    {
        $task = Task::findTask($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if(Task::updateTask($_GET['id'], $_POST['task'])) {
                $this->addFlash('success', 'Task successfully updated');
                $this->redirect('/');
            }
        }

        return $this->render('update-task', ['task' => $task]);
    }
}
