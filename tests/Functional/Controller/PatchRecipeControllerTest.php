<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PatchRecipeControllerTest extends WebTestCase
{
    public function testPatchRecipeSuccess(): void
    {
        $testName = 'test'.rand(1, 393);

        $client = static::createClient();
        $client->request(
            'Patch',
            '/api/v1/recipes/11',
            [],
            [],
            [],
            json_encode(
                [
                    'title' => $testName, 'boxType' => 'box1'
                ]
            )
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPatchRecipeDoesNotExistFailure(): void
    {
        $client = static::createClient();
        $client->request('Patch', '/api/v1/recipes/404');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
