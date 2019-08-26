<?php

declare(strict_types=1);

namespace App\Utility;

use App\Exception\CSVWriteException;
use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Serializer;
use Throwable;

class CSVRecipeUpdateUtility implements RecipeUpdateUtilityInterface
{
    use ArrayCollectionTrait;

    private const ERROR_MESSAGE = 'Unable to save csv file.';
    private $data;
    private $serializer;

    public function __construct(ArrayCollection $data, Serializer $serializer)
    {
        $this->data = $data;
        $this->serializer = $serializer;
    }

    public function update(Recipe $recipe): void
    {
        $date = (new \DateTime())->format(DATE_ISO8601);
        $recipe->setUpdatedAt($date);
        $this->remove($recipe);
        $this->add($recipe);
    }

    public function add(Recipe $recipe): void
    {
        if (!$this->data->contains($recipe)) {
            $this->data->add($recipe);
        }
    }

    public function remove(Recipe $recipe): void
    {
        $exist = $this->data->exists(function ($key, $element) use ($recipe) {
            if ($recipe->id === $element->id) {
                return true;
            }
            return false;
        });

        if ($exist) {
            $this->data->remove($this->getKey($recipe->id, $this->data));
        }
    }

    public function save(string $filename = RecipeCollectionFactoryInterface::CSV_FILENAME): void
    {
        $collection = $this->serializer->normalize($this->data->toArray(), 'csv', ['as_collection' => false]);

        try {
            $content = $this->serializer->serialize(array_values($collection), 'csv');

            file_put_contents($filename, $content);
        } catch (Throwable $exception) {
            throw new CSVWriteException(self::ERROR_MESSAGE);
        }
    }
}
