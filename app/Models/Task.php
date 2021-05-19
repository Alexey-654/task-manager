<?php

namespace App\Models;

use db;
use App\Db\Connection;

class Task
{
    private static $table = 'task';
    private $db;
    public $id;
    public $name;
    public $email;
    public $description;
    public $status;
    public $errors;


    public function __construct($properties = [])
    {
        $this->db = Connection::getInstance()->getConnection();
    }

    public function validate()
    {

    }

    public function save()
    {

    }

    public function createTask($formData): bool
    {
        ['name' => $name, 'email' => $email, 'description' => $description] = $formData;
        $stmt = $this->db->prepare("INSERT INTO task (name, email, description) values (?, ?, ?)");
        return $stmt->execute([$name, $email, $description]);
    }

    public static function updateTask($id, $formData): bool
    {
        $db = self::getConnection();
        ['status' => $status, 'description' => $description] = $formData;
        $stmt = $db->prepare("UPDATE task SET description = ?, status = ?  WHERE id = ?");
        return $stmt->execute([$description, $status, $id]);
    }

    public static function findTask($id): Task
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
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