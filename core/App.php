<?php

namespace Core;

class App
{
    public static $app;

    public function __construct($configs)
    {
        static::$app = $configs;
    }

    public static function getDb()
    {
        return static::$app['db'];
    }

    public static function getUser()
    {
        return static::$app['user'];
    }
}