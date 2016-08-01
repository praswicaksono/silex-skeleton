<?php
declare(strict_types = 1);

use App\Http\Controllers\MainController;
use App\Console\DoctrineFixtureLoadCommand;

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
    \Doctrine\ORM\EntityManager::class => \DI\get('orm.em'),
    DoctrineFixtureLoadCommand::class => \DI\object(DoctrineFixtureLoadCommand::class),
    MainController::class => \DI\object(MainController::class)
]);
