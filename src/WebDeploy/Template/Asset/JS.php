<?php
namespace WebDeploy\Template\Asset;

class JS extends Asset
{
    protected $type = 'js';

    protected function tag($file)
    {
        return '<script src="'.$file.'"></script>';
    }

    protected function minify($file)
    {
        return $this->minifyJS($file);
    }
}
