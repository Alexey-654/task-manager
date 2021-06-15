<?php

namespace App\Controllers;

use App\Models\UserIdentity;
use Core\Controller;
use Core\App;

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ['login' => $login, 'password' => $password] = $_POST['user'];
            $userIdentity = UserIdentity::findUserByLogin($login);
            if($userIdentity && $userIdentity->validatePassword($password)) {
                App::getUser()->login($userIdentity);
                $this->setFlash('success', 'Hello Admin');
                $this->redirect('/');
            } else {
                $this->setFlash('danger', 'Incorrect - Login or Password');
                return $this->render('login', ['userIdentity' => $userIdentity]);
            }
        }
        $userIdentity = new UserIdentity();
        return $this->render('login', ['userIdentity' => $userIdentity]);
    }


    public function logout()
    {
        if (App::getUser()->logout()) {
            session_start();
            $this->setFlash('success', 'You have been logged out successfully');
            $this->redirect('/');
        } else {
            $this->setFlash('danger', 'System Error. Please try again.');
            $this->redirect('/');
        }
    }
}
