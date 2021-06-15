<?php

namespace App\Models;

use Core\BaseModel;

class Task extends BaseModel
{
    public $id;
    public $name;
    public $email;
    public $description;
    public $status;
    public $edited;
    public $errors = [];

    public function load($data): void
    {
        $this->id = $data['id'] ?? $this->id;
        $this->name = $data['name'] ?? $this->name;
        $this->email = $data['email'] ?? $this->email;
        if(!empty($this->description) && $data['description'] !== $this->description) {
            $this->edited = 1;
        } else {
            $this->edited = $data['edited'] ?? 0;
        }
        $this->description = $data['description'] ?? $this->description;
        $this->status = $data['status'] ?? 1;
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
        $db = static::getDb();
        $stmt = $db->prepare("INSERT INTO tasks (name, email, description, status) values (?, ?, ?, ?)");
        return $stmt->execute([$this->name, $this->email, $this->description, $this->status]);
    }

    public function update():bool
    {
        $db = static::getDb();
        $stmt = $db->prepare("UPDATE tasks SET description = ?, status = ?, edited = ?  WHERE id = ?");
        return $stmt->execute([$this->description, $this->status, $this->edited, $this->id]);
    }

    public function validate(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email']['message'] = 'Email is not valid';
        }
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

    public function getStatus(): string
    {
        return $this->getStatusList()[$this->status];
    }

    public static function getStatusList(): array
    {
        return [
            1 => 'new',
            10 => 'completed',
        ];
    }

    public static function findModel($id)
    {
        $db = static::getDb();
        $stmt = $db->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $modelData = $stmt->fetch();
        if ($modelData) {
            $model = new static();
            $model->load($modelData);
            return $model;
        }
        return false;
    }

    public static function getTasks($page, $sort, $perPageLimit = 3): array
    {
        $db = static::getDb();
        $offset = ($page - 1) * $perPageLimit;
        $sort = explode(' ', $sort);
        [$field, $order] = $sort;
        $stmt = $db->prepare("SELECT * FROM tasks ORDER BY $field $order LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPageLimit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getTasksCount(): int
    {
        $db = static::getDb();
        $query = "SELECT COUNT(*) FROM tasks";
        return $db->query($query)->fetchColumn();
    }
}