<?php
declare(strict_types = 1);

use DI\Bridge\Silex\Application;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$_ENV['APP_DEBUG'] = true;
$_ENV['APP_ENV'] = 'dev';
$_ENV['APP_TWIG_AUTO_RELOAD'] = true;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv(__DIR__ . '/../');
    $dotenv->load();
    $dotenv->required('APP_DEBUG')->allowedValues([true, false]);
    $dotenv->required('APP_ENV')->allowedValues(['production', 'development', 'staging', 'dev', 'test']);
    $dotenv->required('APP_TWIG_AUTO_RELOAD')->allowedValues([true, false]);
}

if (! file_exists(__DIR__ . '/../app/config.' . env('APP_ENV', 'dev') .'.php')) {
    throw new Exception('app/config.php not found');
}

$containerBuilder = new ContainerBuilder();

require __DIR__ . '/container.' . env('APP_ENV', 'dev') . '.php';

$app = new Application($containerBuilder, require __DIR__ . '/../app/config.' . env('APP_ENV', 'dev') .'.php');

require __DIR__ . '/services.' . env('APP_ENV', 'dev') . '.php';
require __DIR__ . '/middleware.' . env('APP_ENV', 'dev') . '.php';
require __DIR__ . '/routes.php';

$app->run();
