<?php

declare(strict_types=1);

namespace App\Model;

class FilteredRecipe implements RecipeInterface
{
    public $id;
    public $title;
    public $marketingDescription;


    public function setId(int $id): RecipeInterface
    {
        $this->id = $id;

        return $this;
    }


    public function setTitle(string $title): RecipeInterface
    {
        $this->title = $title;

        return $this;
    }


    public function setMarketingDescription(string $marketingDescription): RecipeInterface
    {
        $this->marketingDescription = $marketingDescription;

        return $this;
    }
}
