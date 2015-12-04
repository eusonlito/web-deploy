<?php
namespace PHPDeploy\Log;

class Dump
{
    public static function debug($title, $message = null, $trace = null)
    {
        $cli = (php_sapi_name() === 'cli');

        echo $cli ? "\n" : '<pre>';
        echo '['.date('Y-m-d H:i:s').'] ';

        if ($message === null) {
            var_dump($title);
        } else {
            echo $title.': ';
            var_dump($message);
        }

        echo $trace ? self::trace() : '';
        echo $cli ? "\n" : '</pre>';
    }

    public static function trace($trace = '')
    {
        $trace = $trace ?: array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 1);

        if (is_string($trace)) {
            return str_replace(PROJECT_PATH, '', $trace);
        }

        $log = '';

        foreach ($trace as $row) {
            $log .= "\n".self::traceWhere($row);
        }

        return trim(str_replace(PROJECT_PATH, '', $log));
    }

    private static function traceWhere($row)
    {
        $line = array_key_exists('line', $row) ? ('#'.$row['line']) : '';

        if (array_key_exists('file', $row)) {
            return $row['file'].$line;
        }

        if (array_key_exists('class', $row)) {
            return $row['class'].$row['type'].$row['function'].$line;
        }

        if (array_key_exists('function', $row)) {
            return $row['function'].$line;
        }
    }
}
