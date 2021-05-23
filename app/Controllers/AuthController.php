<?php

namespace App\Controllers;

use App\Models\UserIdentity;
use Core\Controller;

use function Core\Render\render;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = \Core\App::$app['user'];
            ['login' => $login, 'password' => $password] = $_POST['user'];
            $userIdentity = UserIdentity::findUserByLogin($login);
            if($userIdentity && $userIdentity->validatePassword($password)) {
                \Core\App::$app['user']->login($userIdentity);
                $this->addFlash('success', 'Hello Admin');
                $this->redirect('/');
            } else {
                $this->addFlash('danger', 'Incorrect - Login or Password');
                return $this->render('login', ['userIdentity' => $userIdentity]);
            }
        }
        $userIdentity = new UserIdentity();
        return $this->render('login', ['userIdentity' => $userIdentity]);
    }


    public function logout()
    {
        if (\Core\App::$app['user']->logout()) {
            $this->addFlash('success', 'You have been logged out successfully');
            $this->redirect('/');
        } else {
            $this->addFlash('danger', 'System Error.  Please try again.');
            $this->redirect('/');
        }
    }
}
