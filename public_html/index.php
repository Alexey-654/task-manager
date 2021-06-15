<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Core\Router;
use Core\App;
use App\Controllers\TaskController;
use App\Controllers\AuthController;
use Core\User;
use function Core\Render\render;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$user = isset($_SESSION['identity']) ? new User(true) : new User(false);

$app = new App(['user' => $user]);

$router = new Router();

$router->get('/', fn() => (new TaskController())->index());
$router->get('/create-task', fn() => (new TaskController())->create());
$router->post('/create-task', fn() => (new TaskController())->create());
$router->get('/update-task', fn() => (new TaskController())->update());
$router->post('/update-task', fn() => (new TaskController())->update());
$router->get('/login', fn() => (new AuthController())->login());
$router->post('/login', fn() => (new AuthController())->login());
$router->post('/logout', fn() => (new AuthController())->logout());
$router->get('error', fn() => render('main', '404'));

$router->run();
