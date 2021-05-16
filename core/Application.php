<?php

namespace Core;


class Application
{
    private $handlers = [];

    public function get($route, $handler)
    {
        $this->append('GET', $route, $handler);
    }

    public function post($route, $handler)
    {
        $this->append('POST', $route, $handler);
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        ['path' => $path] = parse_url($uri);
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->handlers as $item) {
            [$route, $handlerMethod, $handler] = $item;
            $preparedRoute = preg_quote($route, '/');
            if ($method === $handlerMethod && preg_match("/^$preparedRoute$/i", $path)) {
                echo $handler();
            }
        }
    }

    private function append($method, $route, $handler)
    {
        $this->handlers[] = [$route, $method, $handler];
    }
}
