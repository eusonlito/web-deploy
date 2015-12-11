<?php
error_reporting(E_ALL);

ini_set('error_reporting', E_ALL);
ini_set('expose_php', 0);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'Europe/Madrid');
}

define('WD_TIME', microtime(true));
define('WD_BASE_PATH', realpath(__DIR__.'/../..'));
define('WD_LIBS_PATH', WD_BASE_PATH.'/src/WebDeploy');

require WD_BASE_PATH.'/src/vendor/autoload.php';
require WD_LIBS_PATH.'/helpers.php';

if (is_file(WD_LIBS_PATH.'/compiled.php')) {
    require WD_LIBS_PATH.'/compiled.php';
} else {
    require WD_LIBS_PATH.'/autoload.php';
}

register_shutdown_function(array('WebDeploy\Handler\Shutdown', 'handle'));
set_error_handler(array('WebDeploy\Handler\Error', 'handle'));
set_exception_handler(array('WebDeploy\Handler\Exception', 'handle'));

WebDeploy\I18n\Gettext::load('es');
