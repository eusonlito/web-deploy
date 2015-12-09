<?php
function d($title, $message = null, $trace = null)
{
    WebDeploy\Log\Dump::debug($title, $message, $trace);
}

function dd($title, $message = null, $trace = null)
{
    die(d($title, $message, $trace));
}

function template()
{
    return WebDeploy\Template\Template::getInstance();
}

function asset($file)
{
    return WebDeploy\Router\Route::getPublicUrl($file);
}