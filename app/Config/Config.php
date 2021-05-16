<?php

namespace App\Config;


class Config
{
    const DSN = 'mysql:host=localhost;dbname=task_manager';
    const DB_USER = 'root2';
    const DB_PASSWORD = 'root2';
    const OPTIONS = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];
}