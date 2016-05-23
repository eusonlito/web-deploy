<?php
namespace WebDeploy\Template;

class Packer
{
    private static $self;

    public static function getInstance()
    {
        return self::$self ?: (self::$self = new self);
    }

    public function css($files)
    {
        return new Asset\CSS($files);
    }

    public function js($files)
    {
        return new Asset\JS($files);
    }
}
