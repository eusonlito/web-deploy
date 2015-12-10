<?php
define('WD_TIME', microtime(true));
define('WD_BASE_PATH', realpath(__DIR__.'/../..'));
define('WD_LIBS_PATH', WD_BASE_PATH.'/src/WebDeploy');

require WD_BASE_PATH.'/src/vendor/autoload.php';
require WD_LIBS_PATH.'/autoload.php';
require WD_LIBS_PATH.'/helpers.php';

if (is_file(WD_LIBS_PATH.'/compiled.php')) {
    require WD_LIBS_PATH.'/compiled.php';
}

WebDeploy\I18n\Gettext::load('es');
