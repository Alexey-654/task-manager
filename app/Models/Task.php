<?php

namespace App\Models;

use db;
use App\Db\Connection;

class Task
{
    public static $table = 'task';
    public $perPageLimit;
    public $db;

    public function __construct($perPageLimit = 3)
    {
        $this->perPageLimit = $perPageLimit;
        $this->db = Connection::getInstance()->getConnection();
    }

    public function createTask($formData)
    {
        ['name' => $name, 'email' => $email, 'description' => $description] = $formData;
        $stmt = $this->db->prepare("INSERT INTO task (name, email, description) values (?, ?, ?)");
        return $stmt->execute([$name, $email, $description]);
    }

    public function updateTask($id, $formData)
    {
        ['status' => $status, 'description' => $description] = $formData;
        $stmt = $this->db->prepare("UPDATE task SET description = ?, status = ?  WHERE id = ?");
        return $stmt->execute([$description, $status, $id]);
    }

    public function getTask($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getTasks($page, $sort)
    {
        $offset = ($page - 1) * $this->perPageLimit;
        $sort = explode(' ', $sort);
        [$field, $order] = $sort;
        $stmt = $this->db->prepare("SELECT * FROM task ORDER BY $field $order LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $this->perPageLimit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalPages()
    {
        $query = "SELECT COUNT(*) FROM task";
        $totalRows = $this->db->query($query)->fetchColumn();
        return ceil($totalRows / $this->perPageLimit);
    }
}