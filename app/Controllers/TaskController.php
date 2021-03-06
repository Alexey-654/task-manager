<?php

namespace App\Controllers;

use Core\Controller;
use Core\App;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $sort = $_GET['sort'] ?? 'id desc';
        $pageQuery = isset($_GET['page']) ? "page={$_GET['page']}&" : '';
        $sortQuery = isset($_GET['sort']) ? "&sort={$_GET['sort']}" : '';
        $perPageLimit = 3;
        $tasks = Task::getTasks($page, $sort, $perPageLimit);
        $totalTasks = Task::getTasksCount();
        $totalPages = ceil($totalTasks / $perPageLimit);

        return $this->render('index', [
                'tasks' => $tasks,
                'totalPages' => $totalPages,
                'pageQuery' => $pageQuery,
                'sortQuery' => $sortQuery,
                'activePage' => $page,
            ]
        );
    }

    public function create()
    {
        $model = new Task();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model->load($_POST['task']);
            if ($model->save()) {
                $this->setFlash('success', 'Task successfully created');
                $this->redirect('/');
            }
        }

        return $this->render('create-task', ['model' => $model,]);
    }

    public function update()
    {
        if (!App::getUser()->isAdmin()) {
            $this->setFlash('danger', 'You don\'t have permission to access this resource');
            $this->redirect('/');
        }

        $model = Task::findModel($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $model->load($_POST['task']);
            if ($model->save()) {
                $this->setFlash('success', 'Task successfully updated');
                $this->redirect('/');
            }
        }

        return $this->render('update-task', ['model' => $model]);
    }
}
