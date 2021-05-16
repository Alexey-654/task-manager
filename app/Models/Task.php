<?php

namespace App\Models;

use PDO;
use App\Config\Config;

class Task
{
    public static $table = 'task';
    public $limit = 10;
    public $pdo;

    public function __construct($limit = null)
    {
        $this->limit = $limit ? $limit : $this->limit;
        $this->pdo = new PDO(Config::DSN, Config::DB_USER, Config::DB_PASSWORD, Config::OPTIONS);
    }

    public function addTask($formData)
    {
        $formData = $this->quoteSQL($formData);
        ['name' => $name, 'email' => $email, 'description' => $description] = $formData;
        return $this->pdo->exec("INSERT into task (name, email, description) values ($name, $email, $description)");
    }

    public function updateTask($id, $formData)
    {
        $data = $this->quoteSQL($formData);
        $id = $this->quoteSQL($id);
        ['status' => $status, 'description' => $description] = $data;
        return $this->pdo->exec("UPDATE task SET description = $description, status = $status  WHERE id = $id;");
    }

    public function getTask($id)
    {
        $query = "SELECT * FROM task WHERE id = $id;";
        $result = $this->pdo->prepare($query);
        $result->execute();
        return $result->fetch();
    }

    public function getTasks($page, $sort)
    {
        $offset = ($page - 1) * $this->limit;
        [$field, $order] = $sort;
        $query = "SELECT * FROM task ORDER BY $field $order LIMIT $this->limit OFFSET $offset;";
        $result = $this->pdo->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    public function getTotalPages()
    {
        $query = "SELECT COUNT(*) FROM task";
        $totalRows = $this->pdo->query($query)->fetchColumn();
        return ceil($totalRows / $this->limit);
    }

    private function quoteSQL($data)
    {
        if (is_array($data)) {
            return array_map(fn($item) => $this->pdo->quote($item), $data);
        }
        return $this->pdo->quote($data);
    }
}