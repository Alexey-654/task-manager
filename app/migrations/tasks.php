<?php

use App\Db\Connection;

require_once __DIR__ . '/../../vendor/autoload.php';

$db = Connection::getInstance()->getConnection();
$sql = <<<SQL
    CREATE TABLE IF NOT EXISTS tasks (
	id serial PRIMARY KEY,
	name varchar(255),
	email varchar(255) UNIQUE,
	description text,
	status integer,
	edited boolean
    );
SQL;

$db->query($sql);
