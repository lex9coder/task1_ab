<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class WebApiTest extends ApiTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        // $response = static::createClient()->request('GET', '/');

        // $this->assertResponseIsSuccessful();
        // $this->assertJsonContains(['@id' => '/']);
    }
}
