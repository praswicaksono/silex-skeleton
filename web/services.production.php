<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\Debug\Debug;

/**
 * register service provider
 */
$app->register(new SessionServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new ServiceControllerServiceProvider());

/**
 * monolog service provider
 */
$monolog_config = $app['monolog_config'];
if ($app['debug'] !== true) {
    $monolog_config['monolog.level'] = \Monolog\Logger::INFO;
}

$app->register(new MonologServiceProvider(), $monolog_config);

/**
 * twig service provider
 */
$app->register(new TwigServiceProvider(), $app['twig_config']);

/**
 * if debug true load debug bar
 */
if ($app['debug'] === true) {
    Debug::enable(E_ALL, true);
    $app->register(new WebProfilerServiceProvider(), [
        'profiler.cache_dir' => __DIR__ . '/../app/cache/profiler'
    ]);

}
