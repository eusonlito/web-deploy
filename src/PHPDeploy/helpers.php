<?php
function d($title, $message = null, $trace = null)
{
    PHPDeploy\Log\Dump::debug($title, $message, $trace);
}

function dd($title, $message = null, $trace = null)
{
    die(d($title, $message, $trace));
}

function template()
{
    return PHPDeploy\Template\Template::getInstance();
}

function asset($file)
{
    return PHPDeploy\Router\Route::getPublicUrl($file);
}