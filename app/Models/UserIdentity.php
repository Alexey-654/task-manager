<?php

namespace App\Models;

use Core\BaseModel;

class UserIdentity extends BaseModel
{
    public $id;
    private $login;
    private $password;

    public function load($data = []): void
    {
        $this->id = $data['id'] ?? $this->id;
        $this->login = $data['login'] ?? $this->login;
        $this->password = $data['password'] ?? $this->password;
    }

    public static function findUserByLogin($login)
    {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $modelData = $stmt->fetch();
        if ($modelData) {
            $model = new static();
            $model->load($modelData);
            return $model;
        }
        return false;
    }

    public function validatePassword($password): bool
    {
        return password_verify($password, $this->password);
    }
}