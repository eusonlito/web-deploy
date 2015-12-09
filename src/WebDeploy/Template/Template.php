<?php
namespace WebDeploy\Template;

use WebDeploy\Router;
use WebDeploy\Exception;

class Template
{
    private static $instance;

    private $templates = array();
    private $shared = array();
    private $path;

    public static function getInstance()
    {
        return static::$instance ?: (static::$instance = new self);
    }

    public function __construct()
    {
        $this->path = Router\Route::getTemplatePath();
    }

    public function set($name, $file, $parameters = array())
    {
        $this->templates[$name] = array(
            'file' => $file,
            'parameters' => $parameters
        );

        return $this;
    }

    public function show($name, $parameters = array())
    {
        if (!is_file($file = $this->file($name))) {
            throw new Exception\UnexpectedValueException(__('Template %s not exists', $file));
        }

        if ($this->shared) {
            extract($this->shared);
        }

        if ($parameters = $this->getParameters($name)) {
            extract($parameters);
        }

        if ($parameters) {
            extract($parameters);
        }

        require $file;
    }

    public function share($parameters = array())
    {
        $this->shared = array_merge($this->shared, $parameters);

        return $this;
    }

    private function getParameters($name)
    {
        if (empty($this->templates[$name]['parameters'])) {
            return array();
        }

        return $this->templates[$name]['parameters'];
    }

    private function file($name)
    {
        if (isset($this->templates[$name]['file'])) {
            $name = $this->templates[$name]['file'];
        }

        return $this->path.'/'.str_replace('.', '/', $name).'.php';
    }
}
