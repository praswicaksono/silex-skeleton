<?php
declare(strict_types=1);

namespace App\Test\Http\Controllers;

use App\Test\CreateApplicationTrait;
use Silex\WebTestCase;

/**
 * Class MainControllerTest
 * @package App\Test\Controllers
 */
class MainControllerTest extends WebTestCase
{
    use CreateApplicationTrait;

    public function testIndexAction()
    {
        $client = $this->createClient();
        
        $client->request('GET', '/');
        $response = $client->getResponse();
        $this->assertTrue($response->isSuccessful());
        $this->assertContains('Hello World', $response->getContent());
    }
}
