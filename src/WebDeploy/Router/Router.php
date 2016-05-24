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

    public function getMethod()
    {
        return $this->parsed['method'];
    }

    public function getController()
    {
        return $this->parsed['controller'];
    }

    public function getArguments()
    {
        return $this->parsed['arguments'];
    }

    public function getRoute()
    {
        return strtolower($this->parsed['controller'].'-'.$this->parsed['method']);
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

        return ucfirst(camelCase($controller));
    }

    private function parseMethod($method)
    {
        if (empty($method)) {
            return 'Index';
        }

        return camelCase($method);
    }
}
