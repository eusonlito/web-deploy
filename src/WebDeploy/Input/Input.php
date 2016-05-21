<?php
namespace WebDeploy\Input;

class Input
{
    private static $input = array();

    private static function load()
    {
        if (empty(self::$input)) {
            self::$input = array_merge($_GET, $_POST);
        }
    }

    public static function get($name = null)
    {
        self::load();

        if ($name === null) {
            return self::$input;
        }

        return array_key_exists($name, self::$input) ? self::$input[$name] : null;
    }

    public static function set($name, $value)
    {
        self::load();

        self::$input[$name] = $value;
    }

    public static function merge(array $values)
    {
        self::load();

        self::$input = array_merge(self::$input, $values);
    }
}
