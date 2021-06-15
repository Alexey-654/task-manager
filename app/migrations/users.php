<?php

use App\Db\DbConnection;

require_once __DIR__ . '/../../vendor/autoload.php';

$db = DbConnection::getInstance()->getDb();
$sql = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
	id serial PRIMARY KEY,
	login varchar(255) UNIQUE,
	password varchar(255)
    );
SQL;

$db->query($sql);
