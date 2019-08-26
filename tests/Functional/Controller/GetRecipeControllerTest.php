<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetRecipeControllerTest extends WebTestCase
{
    private $expectedContent = <<< JSON
{
    "id": 1,
    "createdAt": "30\/06\/2015 17:58:00",
    "updatedAt": "30\/06\/2015 17:58:00",
    "boxType": "vegetarian",    
    "title": "Sweet Chilli and Lime Beef on a Crunchy Fresh Noodle Salad",    
    "slug": "sweet-chilli-and-lime-beef-on-a-crunchy-fresh-noodle-salad",    
    "shortTitle": "",    
    "marketingDescription": "Here we've used onglet steak which is an extra flavoursome cut of beef that should never be cooked past medium rare. So if you're a fan of well done steak, this one may not be for you. However, if you love rare steak and fancy trying a new cut, please be",    
    "caloriesKcal": 401,    
    "proteinGrams": 12,    
    "fatGrams": 35,    
    "carbsGrams": 0,    
    "bulletpoint1": "",    
    "bulletpoint2": "",    
    "bulletpoint3": "",    
    "recipeDietTypeId": "meat",    
    "season": "all",    
    "base": "noodles",    
    "proteinSource": "beef",    
    "preparationTimeMinutes": 35,    
    "shelfLifeDays": 4,    
    "equipmentNeeded": "Appetite",    
    "originCountry": "Great Britain",    
    "recipeCuisine": "asian",    
    "inYourBox": "",    
    "goustoReference": 59    
}
JSON;


    public function testSeeRecipeDetailSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/recipes/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(json_decode($this->expectedContent, true), json_decode($client->getResponse()->getContent(), true));
    }

    public function testSeeRecipeDetailFailure(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/recipes/99');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('Unable to find resource.', $client->getResponse()->getContent());
    }
}
