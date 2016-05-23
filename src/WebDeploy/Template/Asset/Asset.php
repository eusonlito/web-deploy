<?php
namespace WebDeploy\Template\Asset;

use WebDeploy\Filesystem;
use WebDeploy\Router\Route;

abstract class Asset
{
    use Minify;

    protected $files = array();

    public function __construct($files)
    {
        $this->files = $this->files($files);
    }

    public function __toString()
    {
        $name = $this->name();
        $exists = $this->exists($name);

        $html = $code = '';

        foreach ($this->files as $file) {
            if ($this->isExternal($file)) {
                $html .= $this->tag($file);
            } elseif ($exists === false) {
                $code .= $this->code($file);
            }
        }

        if ($code) {
            $this->save($name, $code);
        }

        if ($exists || $code) {
            $html .= $this->tag($this->publicAsset($name));
        }

        return $html;
    }

    protected function exists($name)
    {
        return is_file($this->storageAsset($name));
    }

    protected function code($file)
    {
        return $this->minify(file_get_contents($this->templatesAsset($file)));
    }

    protected function files($files)
    {
        return is_array($files) ? $files : array($files);
    }

    protected function templatesAsset($file)
    {
        return Route::getTemplatePath('/assets/'.ltrim($file, '/'));
    }

    protected function storageAsset($file)
    {
        return Route::getStoragePath('/assets/'.ltrim($file, '/'));
    }

    protected function publicAsset($file)
    {
        return Route::getPublicUrl('/storage/assets/'.ltrim($file, '/'));
    }

    protected function isExternal($file)
    {
        return (strpos($file, '://') !== false);
    }

    protected function name()
    {
        $date = 0;

        foreach ($this->files as $file) {
            if ($this->isExternal($file)) {
                continue;
            }

            if ($date < ($current = filemtime($this->templatesAsset($file)))) {
                $date = $current;
            }
        }

        return $this->type.'/'.($date ? ($date.'-') : '').'min.'.$this->type;
    }

    protected function save($name, $code)
    {
        Filesystem\File::write($this->storageAsset($name), $code);
    }
}
