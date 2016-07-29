<?php

$loader = include_once __DIR__.'/vendor/autoload.php';
$routes = include_once __DIR__.'/configuration/routes.php';

define('ROOT_DIR', __DIR__);

App\Component\Router::setRoutes($routes);

echo App\Component\Router::handle();

exit(0);
