<?php
namespace WebDeploy\App;

use WebDeploy\Exception;
use WebDeploy\Router\Router;

class App
{
    private $router;
    private $namespaces = array(
        'controller' => '\\WebDeploy\\Controller\\',
        'middleware' => '\\WebDeploy\\Middleware\\',
    );

    public function router($route)
    {
        $this->router = new Router($route);

        return $this;
    }

    public function middleware()
    {
        foreach (config('middleware') as $name => $settings) {
            $class = $this->namespaces['middleware'].$name;
            (new $class)->handler($this->router, $settings);
        }

        return $this;
    }

    public function controller()
    {
        $controller = $this->router->getController();
        $class = $this->namespaces['controller'].$controller;

        if (!class_exists($class)) {
            throw new Exception\NotFoundException(__('Controller %s not exists', $controller));
        }

        $method = $this->router->getMethod();
        $class = new $class($this->router);

        if (!method_exists($class, $method)) {
            throw new Exception\NotFoundException(__('Method %s in Controller %s not exists', $method, $controller));
        }

        return call_user_func_array(array($class, $method), $this->router->getArguments());
    }
}
