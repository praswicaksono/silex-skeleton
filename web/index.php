<?php

use Silex\Application;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(require __DIR__ . '/../app/config.php');

require __DIR__ . '/services.php';
require __DIR__ . '/container.php';
require __DIR__ . '/middleware.php';
require __DIR__ . '/routes.php';

$app->run();
