<?php
namespace WebDeploy\Controller;

use Exception as BaseException;
use WebDeploy\Exception;
use WebDeploy\Router\Router;
use WebDeploy\Template\Template;

abstract class Controller
{
    public function __construct(Router $router)
    {
        meta()->set('title', 'Web Deploy');

        template()->share(array(
            'ROUTE' => $router->getRoute(),
            'MODULES' => config('project')['modules']
        ));
    }

    protected function check($module = true, $repository = true)
    {
        $class = array_reverse(explode('\\', get_called_class()))[0];

        try {
            if ($module) {
                self::checkModule(strtolower($class));
            }

            if ($repository) {
                self::checkRepository(($repository === true) ? $class : $repository);
            }
        } catch (BaseException $e) {
            return self::error(strtolower($class), $e->getMessage());
        }
    }

    protected static function checkModule($module)
    {
        if (!in_array($module, config('project')['modules'], true)) {
            throw new Exception\UnexpectedValueException(__('This module is not enabled'));
        }
    }

    protected static function checkRepository($repositories)
    {
        $namespace = str_replace('Controller', 'Repository', __NAMESPACE__);
        $repositories = is_array($repositories) ? $repositories : [$repositories];

        foreach ($repositories as $repository) {
            $repository = $namespace.'\\'.ucfirst($repository);
            $repository::check();
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
