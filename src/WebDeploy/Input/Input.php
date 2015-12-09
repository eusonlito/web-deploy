<?php
namespace WebDeploy\Input;

class Input
{
    private static $input = array();

    private static function load()
    {
        if (empty(static::$input)) {
            static::$input = array_merge($_GET, $_POST);
        }
    }

    public static function get($name = null)
    {
        static::load();

        if ($name === null) {
            return static::$input;
        }

        return array_key_exists($name, static::$input) ? static::$input[$name] : null;
    }

    public static function set($name, $value)
    {
        static::load();

        static::$input[$name] = $value;
    }

    public static function merge(array $values)
    {
        static::load();

        static::$input = array_merge(static::$input, $values);
    }
}
