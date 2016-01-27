<?php

use Jowy\SilexSkeleton\Controllers\MainController;

/**
* PHPDI definition through $containerBuilder
*/

// container config
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);

// change cache driver to more performant on production environment
$containerBuilder->setDefinitionCache(new \Doctrine\Common\Cache\ArrayCache());

$containerBuilder->addDefinitions([
    'Twig_Environment' => \DI\get('twig'),
    MainController::class => \DI\object(MainController::class)
]);
