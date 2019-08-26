<?php

declare(strict_types=1);

namespace App\Utility;

use App\Factory\RecipeCollectionFactoryInterface;

interface RecipeSaveUtilityInterface
{
    public function save(string $filename = RecipeCollectionFactoryInterface::CSV_FILENAME): void;
}
