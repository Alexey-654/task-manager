<?php

namespace App\Db;

class DbConnection
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $dbOptions = getenv('DATABASE_URL')
            ? parse_url(getenv('DATABASE_URL'))
            : parse_url('pgsql://alex-654:root@localhost:5432/task_manager');

        $dbName = ltrim($dbOptions["path"],'/');
        $dsn = "pgsql:host={$dbOptions["host"]};dbname={$dbName};port={$dbOptions['port']}";

        $dbOptions['options'] = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->connection = new \PDO($dsn, $dbOptions["user"], $dbOptions["pass"], $dbOptions['options']);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }

    public function getDb()
    {
        return $this->connection;
    }
}