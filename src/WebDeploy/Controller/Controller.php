<?php
namespace WebDeploy\Controller;

use WebDeploy\Exception;
use WebDeploy\Router\Router;
use WebDeploy\Template\Template;

abstract class Controller
{
    public function __construct(Router $router)
    {
        meta()->title('Web Deploy');

        template()->share(array(
            'ROUTE' => $router->getRoute(),
            'MODULES' => config('project')['modules']
        ));
    }

    protected static function checkModule($module)
    {
        if (!in_array($module, config('project')['modules'], true)) {
            throw new Exception\UnexpectedValueException(__('This module is not enabled'));
        }
    }

    protected static function page($name, $file, array $parameters = array())
    {
        return self::template($name, 'pages.'.$file, $parameters);
    }

    protected static function content($file, array $parameters = array())
    {
        self::page('body', explode('.', $file)[0].'.layout');

        return self::page('content', $file, $parameters);
    }

    protected static function template($name, $file, array $parameters = array())
    {
        return template()->set($name, $file, $parameters);
    }

    protected static function error($layout, $message)
    {
        self::page('body', $layout.'.layout');

        return self::template('content', 'molecules.error', array(
            'message' => $message
        ));
    }
}
