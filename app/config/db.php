<?php

return [
    'dsn' => 'mysql:host=localhost;dbname=task_manager',
    'dbUser' => 'root',
    'dbPassword' => 'root',
    'dbOptions' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ],
];