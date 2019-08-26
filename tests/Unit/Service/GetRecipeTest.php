<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use App\Service\GetRecipe;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\TestCase;

class GetRecipeTest extends TestCase
{
    private $expectedBody = <<<JSON
{
	"id": 1,
	"createdAt": null,
	"updatedAt": null,
	"boxType": null,
	"title": null,
	"slug": null,
	"shortTitle": null,
	"marketingDescription": null,
	"caloriesKcal": null,
	"proteinGrams": null,
	"fatGrams": null,
	"carbsGrams": null,
	"bulletpoint1": null,
	"bulletpoint2": null,
	"bulletpoint3": null,
	"recipeDietTypeId": null,
	"season": null,
	"base": null,
	"proteinSource": null,
	"preparationTimeMinutes": null,
	"shelfLifeDays": null,
	"equipmentNeeded": null,
	"originCountry": null,
	"recipeCuisine": null,
	"inYourBox": null,
	"goustoReference": null
}
JSON;

    /**
     * @var GetRecipe
     */
    private $service;
    /**
     * @var RecipeCollectionFactoryInterface|MockObject
     */
    private $mock;

    protected function setUp()
    {
        $this->mock = $this->createMock(RecipeCollectionFactoryInterface::class);
        $this->service = new GetRecipe($this->mock);
    }

    public function testGetRecipeSuccess()
    {
        $collection = new ArrayCollection();
        $collection->add((new Recipe())->setId(1));
        $collection->add((new Recipe())->setId(2));
        $collection->add((new Recipe())->setId(3));

        $this->mock
            ->method('getCollection')
            ->with(RecipeCollectionFactoryInterface::CSV_FILENAME, Recipe::class)
            ->willReturn($collection);

        $result = $this->service->handle(1);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::HTTP_OK, $result->getStatusCode());
        $this->assertEquals(json_decode($this->expectedBody), json_decode($result->getContent()));
    }

    public function testGetRecipeUnableToFindRecordFailure()
    {
        $this->mock
            ->method('getCollection')
            ->with(RecipeCollectionFactoryInterface::CSV_FILENAME)
            ->willReturn(new ArrayCollection());

        $result = $this->service->handle(0);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::HTTP_NOT_FOUND, $result->getStatusCode());
        $this->assertSame('Unable to find resource.', $result->getContent());
    }
}
