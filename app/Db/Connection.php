<?php

namespace App\Db;

class Connection
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $config = array_merge(
            require __DIR__ . '/../config/db.php',
            require __DIR__ . '/../config/db_local.php',
        );
        $this->connection = new \PDO($config['dsn'], $config['dbUser'], $config['dbPassword'], $config['dbOptions']);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}