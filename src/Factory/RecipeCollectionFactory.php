<?php

declare(strict_types=1);

namespace App\Factory;

use App\Exception\InvalidSetupException;
use App\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Serializer;

class RecipeCollectionFactory implements RecipeCollectionFactoryInterface
{
    private const ERROR_MESSAGE = 'Unable to find file "%s".';

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getCollection(string $filename = self::CSV_FILENAME, string $type = Recipe::class): ArrayCollection
    {
        try {
            $content = file_get_contents($filename, true);
        } catch (\Throwable $exception) {
            throw new NotFoundHttpException(sprintf(self::ERROR_MESSAGE, $filename), $exception);
        }

        $collection = new ArrayCollection();

        try {
            foreach ($this->serializer->decode($content, 'csv', ['as_collection' => false]) as $value) {
                $collection->add(
                    $this->serializer->deserialize(
                        json_encode($value),
                        $type,
                        'json'
                    )
                );
            }
        } catch (RuntimeException $exception) {
            throw new InvalidSetupException($exception->getMessage());
        }

        return $collection;
    }
}
