<?php

namespace Core\Render;


function render($layoutName, $viewName, $variables = [])
{
    $viewDir = realpath(__DIR__ . '/../app/views');
    $viewFilePath = "{$viewDir}/{$viewName}.phtml";
    $layoutFilePath = "{$viewDir}/layouts/{$layoutName}.phtml";

    return renderWithAbsolutePath($layoutFilePath, $viewFilePath, $variables);
}

function renderWithAbsolutePath($layoutFilePath, $viewFilePath, $variables)
{
    extract($variables);
    $viewFilePath;
    ob_start();
    include $layoutFilePath;
    return ob_get_clean();
}