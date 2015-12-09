<?php
namespace WebDeploy\Router;

use WebDeploy\Exception;

class Router
{
    private $url;
    private $parsed;

    public function __construct($url)
    {
        $this->url = $url;
        $this->parsed = $this->parseUrl($url);

        return $this;
    }

    public function getRoute()
    {
        return strtolower($this->parsed['controller'].'-'.$this->parsed['method']);
    }

    public function toController()
    {
        $class = '\\WebDeploy\\Controller\\'.$this->parsed['controller'];

        if (!class_exists($class)) {
            throw new Exception\NotFoundException(__('Controller %s not exists', $this->parsed['controller']));
        }

        $class = new $class($this);

        if (!method_exists($class, $this->parsed['method'])) {
            throw new Exception\NotFoundException(__('Method %s in Controller %s not exists', $this->parsed['method'], $this->parsed['controller']));
        }

        return call_user_func_array(array($class, $this->parsed['method']), $this->parsed['arguments']);
    }

    private function parseUrl($url)
    {
        $url = parse_url($url);
        $path = array_filter(explode('/', str_replace(Route::getPublicPath(), '', $url['path'])));

        $url['controller'] = $this->parseController(array_shift($path));
        $url['method'] = $this->parseMethod(array_shift($path));
        $url['arguments'] = $path;
        $url['query'] = isset($url['query']) ? $url['query'] : '';

        parse_str($url['query'], $url['query']);

        return $url;
    }

    private function parseController($controller)
    {
        if (empty($controller)) {
            return 'Index';
        }

        return ucfirst(preg_replace_callback('/\-(.)/', function ($matches) {
            return strtoupper($matches[1]);
        }, strtolower($controller)));
    }

    private function parseMethod($method)
    {
        if (empty($method)) {
            return 'Index';
        }

        return preg_replace_callback('/\-(.)/', function ($matches) {
            return strtoupper($matches[1]);
        }, strtolower($method));
    }
}
