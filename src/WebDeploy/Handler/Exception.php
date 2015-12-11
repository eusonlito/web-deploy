<?php
namespace WebDeploy\Handler;

class Exception extends ErrorHandler
{
    public static function handle($e)
    {
        self::error($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    }
}
