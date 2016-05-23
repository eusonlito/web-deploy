<?php
namespace WebDeploy\Template;

class Meta
{
    private static $self;
    private $meta = array();

    public static function getInstance()
    {
        return self::$self ?: (self::$self = new self);
    }

    public function set($name, $value)
    {
        $this->meta[$name] = $value;
    }

    public function get($name)
    {
        return isset($this->meta[$name]) ? $this->meta[$name] : null;
    }

    public function tag($name)
    {
        if ($value = $this->get($name)) {
            return '<meta name="'.$name.'" content="'.$value.'" />';
        }
    }
}
