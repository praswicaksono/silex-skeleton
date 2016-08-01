<?php
declare(strict_types = 1);

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\Application;

/**
 * register service provider
 */
$app->register(new SessionServiceProvider(), (array) $app['config']['session']);
$app->register(new HttpFragmentServiceProvider());
$app->register(new HttpCacheServiceProvider(), (array) $app['config']['http_cache']);
$app->register(new ServiceControllerServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), (array) $app['config']['translation']);
$app->register(new ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new CsrfServiceProvider());
$app->register(new RememberMeServiceProvider());
$app->register(new SecurityServiceProvider(), (array) $app['config']['security']);
$app->register(new MonologServiceProvider(), (array) $app['config']['monolog']);
$app->register(new TwigServiceProvider(), (array) $app['config']['twig']);
$app->register(new SerializerServiceProvider());

// extends translator to allow load yaml based translation file
$app->extend('translator', function (Translator $translator, Application $app) {
    foreach ($app['config']['translation']['resources'] as $format => $paths) {
        if ($format === 'yaml') {
            $translator->addLoader($format, new YamlFileLoader());
        }

        foreach ($paths as $locale => $path) {
            $translator->addResource($format, $path, $locale);
        }
    }

    return $translator;
});

/**
 * if debug true load debug bar
 */
if ($app['config']['debug'] === true) {
    Debug::enable(E_ALL, true);
    $app->register(new VarDumperServiceProvider());
    $app->register(new WebProfilerServiceProvider(), [
        'profiler.cache_dir' => __DIR__ . '/../app/cache/profiler'
    ]);
}
