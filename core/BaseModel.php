<?php

namespace Core;

use Core\App;

class BaseModel
{
    protected static function getDb(): \PDO
    {
        return App::getDb();
    }
}
