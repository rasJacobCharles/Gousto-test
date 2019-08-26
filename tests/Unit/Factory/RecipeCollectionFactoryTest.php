<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Exception\InvalidSetupException;
use App\Factory\RecipeCollectionFactory;
use App\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RecipeCollectionFactoryTest extends TestCase
{
    /**@var Serializer */
    private $serializer;

    protected function setUp()
    {
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function testGetCollectionSuccess(): void
    {
        $service = new RecipeCollectionFactory($this->serializer);

        $result = $service->getCollection();

        $this->assertInstanceOf(ArrayCollection::class, $result);
        $this->assertEquals(11, $result->count());
        foreach ($result as $value) {
            $this->assertInstanceOf(Recipe::class, $value);
        }
    }

    public function testGetCollectionInvalidSerializerFailed(): void
    {
        $service = new RecipeCollectionFactory(new Serializer());

        $this->expectException(InvalidSetupException::class);
        $this->expectExceptionMessage('No decoder found for format "csv".');

        $service->getCollection();
    }

    public function testDataSourceNotFoundFailed(): void
    {
        $service = new RecipeCollectionFactory(new Serializer());

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Unable to find file "invalid.csv".');

        $service->getCollection('invalid.csv');
    }
}
