<?php
namespace WebDeploy\Handler;

abstract class ErrorHandler
{
    protected static function error($errno, $errstr, $errfile, $errline)
    {
        if (error_reporting() === 0) {
            return;
        }

        if (PHP_SAPI === 'cli') {
            self::printCli($errno, $errstr, $errfile, $errline);
        } else {
            self::printHtml($errno, $errstr, $errfile, $errline);
        }

        exit;
    }

    protected static function printCli($errno, $errstr, $errfile, $errline)
    {
        echo "\n".$errstr."\n"
            ."\n".'FILE: '.self::getFileName($errfile)
            ."\n".'LINE: '.$errline
            ."\n\n";
    }

    protected static function printHtml($errno, $errstr, $errfile, $errline)
    {
        template()->show('layout.error', array(
            'number' => $errno,
            'code' => self::getErrorName($errno),
            'message' => $errstr,
            'file' => self::getFileName($errfile),
            'line' => $errline,
            'trace' => self::getTrace()
        ));
    }

    protected static function getErrorName($errno)
    {
        switch ($errno) {
            case E_ERROR:             return 'E_ERROR';
            case E_WARNING:           return 'E_WARNING';
            case E_PARSE:             return 'E_PARSE';
            case E_NOTICE:            return 'E_NOTICE';
            case E_CORE_ERROR:        return 'E_CORE_ERROR';
            case E_CORE_WARNING:      return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:     return 'E_COMPILE_ERROR';
            case E_CORE_WARNING:      return 'E_COMPILE_WARNING';
            case E_USER_ERROR:        return 'E_USER_ERROR';
            case E_USER_WARNING:      return 'E_USER_WARNING';
            case E_USER_NOTICE:       return 'E_USER_NOTICE';
            case E_STRICT:            return 'E_STRICT';
            case E_RECOVERABLE_ERROR: return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:        return 'E_DEPRECATED';
            case E_USER_DEPRECATED:   return 'E_USER_DEPRECATED';
        }
    }

    protected static function getTrace()
    {
        $trace = array();

        foreach (array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 3) as $line) {
            if (empty($line['file'])) {
                continue;
            }

            $trace[] = array(
                'file' => self::getFileName($line['file']),
                'line' => (isset($line['line']) ? $line['line'] : ''),
                'function' => (isset($line['function']) ? $line['function'] : ''),
                'class' => (isset($line['class']) ? $line['class'] : '')
            );
        }

        return $trace;
    }

    protected static function getFileName($file)
    {
        return str_replace(WD_BASE_PATH, '', $file);
    }
}
