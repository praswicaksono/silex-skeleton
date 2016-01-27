<?php

use Jowy\SilexSkeleton\Controllers\MainController;

/**
* PHPDI definition through $containerBuilder
*/

$containerBuilder->addDefinitions([
    'Twig_Environment' => \DI\get('twig'),
    MainController::class => \DI\object(MainController::class)
]);
