<?php
use WebDeploy\Router\Route;

return array(
    'environment' => 'prod',
    'ignore_environments' => [],
    'public_path' => Route::getBasePath(),
    'asset' => Route::getPublicUrl(),
    'cache_folder' => Route::getStoragePath('/cache'),
    'check_timestamps' => true,
    'css_minify' => true,
    'js_minify' => true,
    'images_fake' => true
);
