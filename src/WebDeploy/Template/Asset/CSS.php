<?php
namespace WebDeploy\Template\Asset;

class CSS extends Asset
{
    protected $type = 'css';

    protected function tag($file)
    {
        return '<link href="'.$file.'" rel="stylesheet" />';
    }

    protected function minify($file)
    {
        return $this->minifyCSS($file);
    }
}
