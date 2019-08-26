<?php

declare(strict_types=1);

namespace App\Factory;

use App\Model\Recipe;
use Doctrine\Common\Collections\ArrayCollection;

interface RecipeCollectionFactoryInterface
{
    public const CSV_FILENAME = 'recipe-data.csv';

    public function getCollection(string $filename = self::CSV_FILENAME, string $type = Recipe::class): ArrayCollection;
}
