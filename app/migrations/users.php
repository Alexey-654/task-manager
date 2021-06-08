<?php

use App\Db\Connection;

require_once __DIR__ . '/../../vendor/autoload.php';

$db = Connection::getInstance()->getConnection();
$sql = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
	id serial PRIMARY KEY,
	login varchar(255) UNIQUE,
	password varchar(255)
    );
SQL;

$db->query($sql);
