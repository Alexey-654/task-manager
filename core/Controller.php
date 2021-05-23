<?php

namespace Core;

use function Core\Render\render;

class Controller
{
    public function redirect($url, $responseCode = 302)
    {
        header("Location: $url", true, $responseCode);
        die;
    }

    public function render($view, $params = [])
    {
        return render($view, $params);
    }

    public function addFlash($class, $message)
    {
        $_SESSION['flash'] = ['class' => $class, 'message' => $message];
    }
}
