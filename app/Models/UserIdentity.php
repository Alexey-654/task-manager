<?php

namespace App\Models;

use App\Db\Connection;

class UserIdentity
{
    public $id;
    public $role;
    private $login;
    private $password;

    public function load($data = [])
    {
        $this->id = $data['id'] ?? $this->id;
        $this->login = $data['login'] ?? $this->login;
        $this->password = $data['password'] ?? $this->password;
        $this->role = $data['role'] ?? $this->role;
    }

    public static function findUserByLogin($login)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM user WHERE login = ?");
        $stmt->execute([$login]);
        $modelData = $stmt->fetch();
        if ($modelData) {
            $model = new self();
            $model->load($modelData);
            return $model;
        }
        return false;
    }

    public function validatePassword($password): bool
    {
        return password_verify($password, $this->password);
    }

    private static function getConnection(): \PDO
    {
        return Connection::getInstance()->getConnection();
    }
}