<?php

namespace Core;

use function Core\Render\render;

class Controller
{
    public $layout = 'main';

    public function redirect($url, $responseCode = 302)
    {
        header("Location: $url", true, $responseCode);
        die;
    }

    public function render($view, $variables = [])
    {
        return render($this->layout, $view, $variables);
    }

    public function setFlash($class, $message)
    {
        $_SESSION['flash'] = ['class' => $class, 'message' => $message];
    }
}
