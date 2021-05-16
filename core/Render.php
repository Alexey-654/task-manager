<?php

namespace Core\Render;


function render($filepath, $params = [])
{
    $viewsDir = realpath(__DIR__ . '/../app/views');
    $templatePath = "{$viewsDir}/{$filepath}.phtml";

    return renderWithAbsolutePath($templatePath, $params);
}

function renderWithAbsolutePath($template, $variables)
{
    extract($variables);
    ob_start();
    echo 'test';
    include $template;
    return ob_get_clean();
}