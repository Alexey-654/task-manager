<?php

use App\Db\DbConnection;

require_once __DIR__ . '/../../vendor/autoload.php';

$db = DbConnection::getInstance()->getDb();
$sqlCrateTable = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
	id serial PRIMARY KEY,
	login varchar(255) UNIQUE,
	password varchar(255)
    );
SQL;

$sqlAddAdmin = <<<SQL
	INSERT INTO users (login, password)
		VALUES ('admin', '123');
SQL;

$db->query($sqlCrateTable);
$db->query($sqlAddAdmin);