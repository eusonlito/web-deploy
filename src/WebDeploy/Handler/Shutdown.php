<?php
namespace WebDeploy\Handler;

class Shutdown extends ErrorHandler
{
    public static function handle()
    {
        if (!($error = error_get_last())) {
            return;
        }

        self::error($error['type'], $error['message'], $error['file'], $error['line']);
    }
}
