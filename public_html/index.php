<?php

use Core\Router;
use App\Controllers\TaskController;
use App\Controllers\AuthController;
use function Core\Render\render;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router->get('/', fn() => (new TaskController())->index());
$router->get('/create-task', fn() => (new TaskController())->create());
$router->post('/create-task', fn() => (new TaskController())->create());
$router->get('/update-task', fn() => (new TaskController())->update());
$router->post('/update-task', fn() => (new TaskController())->update());
$router->get('/login', fn() => (new AuthController())->login());
$router->post('/login', fn() => (new AuthController())->login());
$router->post('/logout', fn() => (new AuthController())->logout());
$router->get('error', fn() => render('404'));

$router->run();
