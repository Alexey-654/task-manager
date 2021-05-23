<?php

namespace Core;

class User
{
    private $isAdmin;

    public function __construct($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function login($userIdentity)
    {
        if ($userIdentity->role === 'admin') {
            $this->isAdmin = true;
        }
        $_SESSION['identity'] = $userIdentity->id;
    }

    public function logout(): bool
    {
        return session_destroy();
    }
}