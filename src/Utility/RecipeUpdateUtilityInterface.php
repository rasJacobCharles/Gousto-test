<?php

declare(strict_types=1);

namespace App\Utility;

use App\Model\Recipe;

interface RecipeUpdateUtilityInterface extends RecipeSaveUtilityInterface
{
    public function update(Recipe $recipe): void;
}
