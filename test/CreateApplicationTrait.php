<?php
declare(strict_types = 1);

namespace App\Test;

use DI\Bridge\Silex\Application;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

/**
 * Class CreateApplicationTrait
 * @package App\Test
 */
trait CreateApplicationTrait
{
    /**
     * @return Application
     * @throws \Exception
     */
    public function createApplication()
    {
        if (file_exists(__DIR__ . '/../.env')) {
            $dotenv = new Dotenv(__DIR__ . '/../');
            $dotenv->load();
            $dotenv->required('APP_DEBUG')->allowedValues([true, false]);
            $dotenv->required('APP_ENV')->allowedValues(['production', 'development', 'staging', 'dev', 'test']);
            $dotenv->required('APP_TWIG_AUTO_RELOAD')->allowedValues([true, false]);
        }

        if (! file_exists(__DIR__ . '/../app/config.php')) {
            throw new \Exception("app/config.php not found");
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

        $containerBuilder = new ContainerBuilder();

        require __DIR__ . '/../web/container.' . env('APP_ENV', 'production') . '.php';

        $app = new Application($containerBuilder, require __DIR__ . '/../app/config.php');

        require __DIR__ . '/../web/services.' . env('APP_ENV', 'production') . '.php';
        require __DIR__ . '/../web/middleware.' . env('APP_ENV', 'production') . '.php';
        require __DIR__ . '/../web/routes.php';

        return $app;
    }
}
