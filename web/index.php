<?php

use DI\Bridge\Silex\Application;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

if (! file_exists(__DIR__ . '/../app/config.php')) {
    throw new Exception("app/config.php not found");

}

$containerBuilder = new ContainerBuilder();

require __DIR__ . '/container.php';

$app = new Application($containerBuilder, require __DIR__ . '/../app/config.php');

require __DIR__ . '/services.php';
require __DIR__ . '/middleware.php';
require __DIR__ . '/routes.php';

$app->run();
