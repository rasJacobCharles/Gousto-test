<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Factory\PaginationFactory;
use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use App\Service\FindRecipes;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\TestCase;

class FindRecipeTest extends TestCase
{
    private $expectedBody = <<<JSON
{
	"result": [{
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
	}, {
		"id": 2,
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
	}, {
		"id": 3,
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
	}],
	"numberOfResult": 3,
	"pageNumber": 1,
	"links": {
		"self": "/api/v1/recipes",
		"first": "/api/v1/recipes",
		"last": "/api/v1/recipes"
	}
}
JSON;

    private $service;
    /**@var RecipeCollectionFactoryInterface|MockObject */
    private $mockCollect;


    protected function setUp(): void
    {
        $mockRouter = $this->createMock(Router::class);
        $mockRouter
            ->method('generate')
            ->withAnyParameters()
            ->willReturn('/api/v1/recipes');
        $this->mockCollect = $this->createMock(RecipeCollectionFactoryInterface::class);
        $paginationFactory = new PaginationFactory($mockRouter);
        $this->service = new FindRecipes($this->mockCollect, $paginationFactory);
    }

    public function testFindSuccess(): void
    {
        $collection = new ArrayCollection();
        $collection->add((new Recipe())->setId(1));
        $collection->add((new Recipe())->setId(2));
        $collection->add((new Recipe())->setId(3));

        $this->mockCollect
            ->method('getCollection')
            ->with(RecipeCollectionFactoryInterface::CSV_FILENAME)
            ->willReturn($collection);

        $result = $this->service->handle(new Request(['page' => 1]));

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::HTTP_OK, $result->getStatusCode());
        $this->assertEquals(json_decode($this->expectedBody), json_decode($result->getContent()));
    }

    public function testGetRecipeUnableToFindRecordFailure(): void
    {
        $this->mockCollect
            ->method('getCollection')
            ->with(RecipeCollectionFactoryInterface::CSV_FILENAME)
            ->willReturn(new ArrayCollection());

        $result = $this->service->handle(new Request(['page' => 9]));

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $result->getStatusCode());
        $this->assertSame('Page "9" does not exist. The currentPage must be inferior to "1"', $result->getContent());
    }
}
