<?php

namespace Core;

class User
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function login($userIdentity): void
    {
        $this->role = 'admin';
        $_SESSION['identity'] = $userIdentity->id;
    }

    public function logout(): bool
    {
        return session_destroy();
    }
}