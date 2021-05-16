<?php

use Core\Application;
use App\Controllers\TaskController;
use App\Controllers\AuthController;
use function Core\Render\render;

require_once __DIR__ . '/../vendor/autoload.php';


$app = new Application();

$app->get('/', fn() => (new TaskController())->index());
$app->get('/create-task', fn() => (new TaskController())->create());
$app->post('/create-task', fn() => (new TaskController())->create());
$app->get('/update-task', fn() => (new TaskController())->update());
$app->post('/update-task', fn() => (new TaskController())->update());
$app->get('/login', fn() => (new AuthController())->login());
$app->post('/login', fn() => (new AuthController())->login());
$app->post('/logout', fn() => (new AuthController())->logout());

$app->run();
