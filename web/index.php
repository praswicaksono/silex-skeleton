<?php
declare(strict_types = 1);

use DI\Bridge\Silex\Application;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv(__DIR__ . '/../');
    $dotenv->load();
    $dotenv->required('APP_DEBUG')->allowedValues([true, false]);
    $dotenv->required('APP_ENV')->allowedValues(['production', 'development', 'staging']);
    $dotenv->required('APP_TWIG_AUTO_RELOAD')->allowedValues([true, false]);
}

if (! function_exists('env')) {
    function env($name, $default)
    {
        if (isset($_ENV[$name])) {
            return $_ENV[$name];
        }

        return $default;
    }
}

if (! file_exists(__DIR__ . '/../app/config.php')) {
    throw new Exception("app/config.php not found");
}

$containerBuilder = new ContainerBuilder();

require __DIR__ . '/container.' . env('APP_ENV', 'production') . '.php';

$app = new Application($containerBuilder, require __DIR__ . '/../app/config.php');

require __DIR__ . '/services.' . env('APP_ENV', 'production') . '.php';
require __DIR__ . '/middleware.' . env('APP_ENV', 'production') . '.php';
require __DIR__ . '/routes.php';

$app->run();
