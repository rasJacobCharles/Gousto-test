<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetRecipesListControllerTest extends WebTestCase
{
    private $expectedBody = <<<JSON
{
    "result": [
        {
            "id": 1,
            "title": "Sweet Chilli and Lime Beef on a Crunchy Fresh Noodle Salad",
            "marketingDescription": "Here we've used onglet steak which is an extra flavoursome cut of beef that should never be cooked past medium rare. So if you're a fan of well done steak, this one may not be for you. However, if you love rare steak and fancy trying a new cut, please be"
        },
        {
            "id": 2,
            "title": "Tamil Nadu Prawn Masala",
            "marketingDescription": "Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed"
        },
        {
            "id": 3,
            "title": "Umbrian Wild Boar Salami Ragu with Linguine",
            "marketingDescription": "This delicious pasta dish comes from the Italian region of Umbria. It has a smoky and intense wild boar flavour which combines the earthy garlic, leek and onion flavours, while the chilli flakes add a nice deep aroma. Enjoy within 5-6 days of delivery."
        },
        {
            "id": 4,
            "title": "Tenderstem and Portobello Mushrooms with Corn Polenta",
            "marketingDescription": "One for those who like their veggies with a slightly spicy kick. However, those short on time, be warned ' this is a time-consuming dish, but if you're willing to spend a few extra minutes in the kitchen, the fresh corn mash is extraordinary and worth a t"
        },
        {
            "id": 5,
            "title": "Fennel Crusted Pork with Italian Butter Beans",
            "marketingDescription": "A classic roast with a twist. The pork loin is marinated in rosemary, fennel seeds and chilli flakes then teamed with baked potato wedges and butter beans in tomato sauce. Enjoy within 5-6 days of delivery."
        },
        {
            "id": 6,
            "title": "Pork Chilli",
            "marketingDescription": "Succulent pork tenderloin and feathery white bean and parsnip mash mingle with feisty cumin seeds and tangy leek in this lighter, less conventional take on a British classic. Welcome to the outer limits of food!"
        },
        {
            "id": 7,
            "title": "Courgette Pasta Rags",
            "marketingDescription": "Kick-start the new year with some get-up and go with this lean green vitality machine. Protein-packed chicken and mineral-rich kale are blended into a smooth, nut-free version of pesto; creating the ultimate composition of nutrition and taste"
        },
        {
            "id": 8,
            "title": "Homemade Eggs & Beans",
            "marketingDescription": "A Goustofied British institution, learn how to make beautifully golden breaded chicken escalopes drizzled in homemade garlic butter and served atop fluffy potato and broccoli mash."
        },
        {
            "id": 9,
            "title": "Grilled Jerusalem Fish",
            "marketingDescription": "I love this super healthy fish dish, it contains a punch from zingy ginger, a kick from chili and a salty sweet balance from soy sauce and mirim. A cleansing and restorative meal, great for body and soul."
        },
        {
            "id": 10,
            "title": "Pork Katsu Curry",
            "marketingDescription": "Comprising all the best bits of the classic American number and none of the mayo, this is a warm & tasty chicken and bulgur salad with just a hint of Scandi influence. A beautifully summery medley of flavours and textures"
        }
    ],
    "numberOfResult": 11,
    "pageNumber": 1,
    "links": {
        "self": "http://localhost/api\/v1\/recipes?page=1",
        "first": "http://localhost\/api\/v1\/recipes?page=1",
        "last": "http://localhost\/api\/v1\/recipes?page=2",
        "next": "http://localhost\/api\/v1\/recipes?page=2"
    }
}
JSON;

    public function testSeeRecipeDetailSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/recipes');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(json_decode($this->expectedBody), json_decode($client->getResponse()->getContent()));
    }

    public function testFailurePageDoesNotExist(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/recipes', ['page' => 3]);

        $this->assertEquals(
            400,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals(
            'Page "3" does not exist. The currentPage must be inferior to "2"',
            $client->getResponse()->getContent()
        );
    }
}
