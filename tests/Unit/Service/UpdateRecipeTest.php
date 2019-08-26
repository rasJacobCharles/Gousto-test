<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use App\Service\UpdateRecipe;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UpdateRecipeTest extends TestCase
{
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var RecipeCollectionFactoryInterface|MockObject
     */
    private $mockCollectionFactory;

    protected function setUp(): void
    {
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
        $this->mockCollectionFactory = $this->createMock(RecipeCollectionFactoryInterface::class);
        fopen("test.csv", "w");
    }

    public function testSuccessUpdateRecipe()
    {
        $title = 'test'.rand(1,99);
        $expectResult = new Recipe();
        $expectResult
            ->setId(1)
            ->setCreatedAt("30/06/2015 17:58:00")
            ->setUpdatedAt("30/06/2015 17:58:00")
            ->setBoxType("gourmet")
            ->setTitle("Tamil Nadu Prawn Masala")
            ->setSlug("tamil - nadu - prawn - masala")
            ->setMarketingDescription("Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed")
            ->setCaloriesKcal(524)
            ->setProteinGrams(12)
            ->setFatGrams(22)
            ->setCarbsGrams(0)
            ->setBulletpoint1("Vibrant & Fresh")
            ->setBulletpoint2("Warming, not spicy")
            ->setBulletpoint3("Curry From Scratch")
            ->setRecipeDietTypeId("fish")
            ->setSeason('all')
            ->setBase('pasta')
            ->setProteinSource("seafood")
            ->setPreparationTimeMinutes(40)
            ->setShelfLifeDays(4)
            ->setEquipmentNeeded("Appetite")
            ->setOriginCountry("Great Britain")
            ->setRecipeCuisine("italian")
            ->setInYourBox("king prawns, basmati rice, onion, tomatoes, garlic, ginger, ground tumeric, red chilli powder, ground cumin, fresh coriander, curry leaves, fennel seeds")
            ->setGoustoReference(58);

        $this->mockCollectionFactory
            ->expects($this->once())
            ->method('getCollection')
            ->with()
            ->willReturn(new ArrayCollection([$expectResult]));

        $service = new UpdateRecipe($this->mockCollectionFactory, $this->serializer, 'test.csv');
        $request = new Request(
           [],
           [],
           [],
           [],
           [],
           [],
           json_encode(['title' => $title])
       );

        $result = $service->handle(1, $request);

        $this->assertStringContainsString($title, $result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertStringContainsString($title, file_get_contents('test.csv'));
    }

    public function testFailureUpdateRecipeAsRecordDoesNotExist()
    {
        $this->mockCollectionFactory
            ->expects($this->once())
            ->method('getCollection')
            ->with()
            ->willReturn(new ArrayCollection());

        $service = new UpdateRecipe($this->mockCollectionFactory, $this->serializer);
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            json_encode(['title' => 'test'])
        );

        $result = $service->handle(99, $request);

        $this->assertEquals(404, $result->getStatusCode());
        $this->assertEquals('Id does not refer to exist record.', $result->getContent());
    }

    public function testFailureUpdateRecipeCSVDoesNotExist()
    {
        $expectResult = new Recipe();
        $expectResult->setId(1);
        $this->mockCollectionFactory
            ->expects($this->once())
            ->method('getCollection')
            ->with()
            ->willReturn(new ArrayCollection([$expectResult]));

        $service = new UpdateRecipe($this->mockCollectionFactory, $this->serializer, '../../../unknown.csv');
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            json_encode(['title' => 'test'])
        );

        $result = $service->handle(1, $request);

        $this->assertEquals(500, $result->getStatusCode());
        $this->assertEquals('Unable to save csv file.', $result->getContent());
    }
}
