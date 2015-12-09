<?php
spl_autoload_register(function ($className) {
    if (strpos($className, 'WebDeploy') !== 0) {
        return;
    }

    $fileName = dirname(__DIR__).'/';

    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }

    $fileName .= $className.'.php';

    if (is_file($fileName)) {
        require $fileName;
    }
});
