<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController.
 */
class MainController implements ControllerProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application $app
     *
     * @return ControllerCollection
     */
    public function connect(Application $app) : ControllerCollection
    {
        $this->app = $app;
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'indexAction'])->bind('homepage');

        return $controllers;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request) : Response
    {
        return Response::create($this->app['twig']->render('index.twig'));
    }
}
