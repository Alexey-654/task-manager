<?php

namespace Core;

class App
{
    public static $app;

    public function __construct($configs)
    {
        static::$app = $configs;
    }
}