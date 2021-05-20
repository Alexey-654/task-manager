<?php

namespace App\Models;

use App\Db\Connection;

class Task
{
    private static $table = 'task';
    public $id;
    public $name;
    public $email;
    public $description;
    public $status;
    public $errors = [];

    public function load($data = [])
    {
        $this->id = $data['id'] ?? $this->id;
        $this->name = $data['name'] ?? $this->name;
        $this->email = $data['email'] ?? $this->email;
        $this->description = $data['description'] ?? $this->description;
        $this->status = $data['status'] ?? $this->status;
    }

    public function save(): bool
    {
        $this->validate();
        if(!empty($this->errors)) {
            return false;
        }
        if (!$this->id) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    public function insert():bool
    {
        $db = self::getConnection();
        $stmt = $db->prepare("INSERT INTO task (name, email, description) values (?, ?, ?)");
        return $stmt->execute([$this->name, $this->email, $this->description]);
    }

    public function update():bool
    {
        $db = self::getConnection();
        $stmt = $db->prepare("UPDATE task SET description = ?, status = ?  WHERE id = ?");
        return $stmt->execute([$this->description, $this->status, $this->id]);
    }

    public function validate()
    {
        if (empty($this->name)) {
            $this->errors['name']['message'] = 'Field name is required';
        }
        if (empty($this->email)) {
            $this->errors['email']['message'] = 'Field email is required';
        }
        if (empty($this->description)) {
            $this->errors['description']['message'] = 'Field description is required';
        }
    }

    public static function findModel($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$id]);
        $modelData = $stmt->fetch();
        if ($modelData) {
            $model = new self();
            $model->load($modelData);
            return $model;
        }
        return false;
    }

    public static function getTasks($page, $sort, $perPageLimit = 3): array
    {
        $db = self::getConnection();
        $offset = ($page - 1) * $perPageLimit;
        $sort = explode(' ', $sort);
        [$field, $order] = $sort;
        $stmt = $db->prepare("SELECT * FROM task ORDER BY $field $order LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPageLimit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getTasksCount(): int
    {
        $db = self::getConnection();
        $query = "SELECT COUNT(*) FROM task";
        return $db->query($query)->fetchColumn();
    }

    private static function getConnection(): \PDO
    {
        return Connection::getInstance()->getConnection();
    }
}
