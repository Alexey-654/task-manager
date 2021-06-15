<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use function Core\Render\render;
use Core\Router;
use Core\App;
use Core\User;
use App\Controllers\TaskController;
use App\Controllers\AuthController;
use App\Db\DbConnection;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$user = isset($_SESSION['identity']) ? new User('admin') : new User('guest');
$db = DbConnection::getInstance()->getDb();
$router = new Router();

$app = new App([
    'user' => $user,
    'db' => $db,
]);

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
