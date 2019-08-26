<?php

declare(strict_types=1);

namespace App\Tests\Unit\Utility;

use App\Exception\CSVWriteException;
use App\Factory\RecipeCollectionFactory;
use App\Model\Recipe;
use App\Utility\CSVRecipeUpdateUtility;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CSVUpdateTest extends TestCase
{
    private $arrayCollection;
    private $service;
    private $collectionFactory;


    protected function setUp(): void
    {
        $this->arrayCollection = new ArrayCollection(
            [
                $this->createRecipe(1),
                $this->createRecipe(2),
                $this->createRecipe(3)
            ]
        );
        fopen("test.csv", "w");

        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $this->service = new CSVRecipeUpdateUtility($this->arrayCollection, $serializer);
        $this->collectionFactory = new RecipeCollectionFactory($serializer);
    }

    public function testSuccessSaveContentToCSV()
    {
        $this->service->save('test.csv');

        $collection = $this->collectionFactory->getCollection('test.csv');
        $this->assertEquals($collection, $this->arrayCollection);
    }

    /**
     * @dataProvider invalidFilenameDataProvider
     */
    public function testFailureUnableToSaveCVS(string $filename)
    {
        $this->expectException(CSVWriteException::class);
        $this->expectExceptionMessage('Unable to save csv file.');

        $this->service->save($filename);
    }

    public function testSuccessAddRecord()
    {
        $this->service->add($record = $this->createRecipe(4));
        $this->service->save('test.csv');


        $collection = $this->collectionFactory->getCollection('test.csv');

        $this->assertEquals(4, $collection->count());
        $this->assertEquals($record, $collection->last());
    }

    public function testSuccessCanOnlySameRecordOnce()
    {
        $this->service->add($record = $this->createRecipe(4));
        $this->service->add($record);
        $this->service->save('test.csv');


        $collection = $this->collectionFactory->getCollection('test.csv');

        $this->assertEquals(4, $collection->count());
        $this->assertEquals($record, $collection->last());
    }

    public function testSuccessRemoveRecordThatExist()
    {
        $this->service->remove($this->arrayCollection->last());
        $this->service->save('test.csv');
        $collection = $this->collectionFactory->getCollection('test.csv');

        $this->assertEquals(2, $collection->count());
    }

    public function testSuccessUpdateRecord()
    {
        $record =  $this->createRecipe(1);
        $record->title = 'test';
        $this->service->update($record);
        $this->service->save('test.csv');
        $collection = $this->collectionFactory->getCollection('test.csv');


        $this->assertEquals(3, $collection->count());
        $this->assertEquals($record->title, $collection->last()->title);
        $this->assertEquals($record->id, $collection->last()->id);
    }

    public function testSuccessRemoveRecordDoesNotExist()
    {
        $this->service->remove($this->createRecipe(4));
        $this->service->save('test.csv');
        $collection = $this->collectionFactory->getCollection('test.csv');

        $this->assertEquals(3, $collection->count());
    }

    public function invalidFilenameDataProvider()
    {
        return [
            [''],
            ['..'],
            ['../../../t'],
        ];
    }


    protected function tearDown(): void
    {
        unset($this->arrayCollection);
        unset($this->service);
        unlink("test.csv");
        parent::tearDown();
    }

    private function createRecipe(int $id)
    {
        $items = ["fish", "veg", "chicken"];
        return (new Recipe())
        ->setId($id)
        ->setCreatedAt("30/06/2015 17:58:00")
        ->setUpdatedAt("30/06/2015 17:58:00")
        ->setBoxType("gourmet")
        ->setTitle("Tamil Nadu Prawn Masala")
        ->setSlug("tamil - nadu - prawn - masala")
        ->setMarketingDescription("Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed")
        ->setCaloriesKcal(rand(100, 1000))
        ->setProteinGrams(rand(0, 64))
        ->setFatGrams(rand(1, 1000))
        ->setCarbsGrams(rand(0, 300))
        ->setBulletpoint1("Vibrant & Fresh")
        ->setBulletpoint2("Warming, not spicy")
        ->setBulletpoint3("Curry From Scratch")
        ->setRecipeDietTypeId($items[array_rand($items)])
        ->setSeason('all')
        ->setBase('pasta')
        ->setProteinSource($items[array_rand($items)])
        ->setPreparationTimeMinutes(40)
        ->setShelfLifeDays(4)
        ->setEquipmentNeeded("Appetite")
        ->setOriginCountry("Great Britain")
        ->setRecipeCuisine("italian")
        ->setInYourBox("king prawns, basmati rice, onion, tomatoes, garlic, ginger, ground tumeric, red chilli powder, ground cumin, fresh coriander, curry leaves, fennel seeds")
        ->setGoustoReference(58);
    }
}
