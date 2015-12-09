<?php
namespace WebDeploy\Template;

use WebDeploy\Router;
use WebDeploy\Exception;

class Template
{
    private static $instance;

    private $templates;
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
            'arguments' => $parameters
        );

        return $this;
    }

    public function show($name, $parameters = array())
    {
        if (!is_file($file = $this->file($name))) {
            throw new Exception\UnexpectedValueException(__('Template %s not exists', $file));
        }

        if ($parameters) {
            extract($parameters);
        }

        if ($parameters = $this->getParameters($name)) {
            extract($parameters);
        }

        require $file;
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