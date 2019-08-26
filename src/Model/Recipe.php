<?php

declare(strict_types=1);

namespace App\Model;

class Recipe implements RecipeInterface
{
    public $id;
    public $createdAt;
    public $updatedAt;
    public $boxType;
    public $title;
    public $slug;
    public $shortTitle;
    public $marketingDescription;
    public $caloriesKcal;
    public $proteinGrams;
    public $fatGrams;
    public $carbsGrams;
    public $bulletpoint1;
    public $bulletpoint2;
    public $bulletpoint3;
    public $recipeDietTypeId;
    public $season;
    public $base;
    public $proteinSource;
    public $preparationTimeMinutes;
    public $shelfLifeDays;
    public $equipmentNeeded;
    public $originCountry;
    public $recipeCuisine;
    public $inYourBox;
    public $goustoReference;

    public function setId(int $id): RecipeInterface
    {
        $this->id = $id;

        return $this;
    }

    public function setCreatedAt(string $createdAt): RecipeInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(string $updatedAt): RecipeInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setBoxType(string $boxType): RecipeInterface
    {
        $this->boxType = $boxType;

        return $this;
    }

    public function setTitle(string $title): RecipeInterface
    {
        $this->title = $title;

        return $this;
    }

    public function setSlug(string $slug): RecipeInterface
    {
        $this->slug = $slug;

        return $this;
    }

    public function setShortTitle(string $shortTitle): RecipeInterface
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    public function setMarketingDescription(string $marketingDescription): RecipeInterface
    {
        $this->marketingDescription = $marketingDescription;

        return $this;
    }

    public function setCaloriesKcal(int $caloriesKcal): RecipeInterface
    {
        $this->caloriesKcal = $caloriesKcal;

        return $this;
    }

    public function setProteinGrams(int $proteinGrams): RecipeInterface
    {
        $this->proteinGrams = $proteinGrams;

        return $this;
    }

    public function setFatGrams(int $fatGrams): RecipeInterface
    {
        $this->fatGrams = $fatGrams;

        return $this;
    }

    public function setCarbsGrams(int $carbsGrams): RecipeInterface
    {
        $this->carbsGrams = $carbsGrams;

        return $this;
    }

    public function setBulletpoint1(string $bulletpoint1): RecipeInterface
    {
        $this->bulletpoint1 = $bulletpoint1;

        return $this;
    }

    public function setBulletpoint2(string $bulletpoint2): RecipeInterface
    {
        $this->bulletpoint2 = $bulletpoint2;

        return $this;
    }

    public function setBulletpoint3(string $bulletpoint3): RecipeInterface
    {
        $this->bulletpoint3 = $bulletpoint3;

        return $this;
    }

    public function setRecipeDietTypeId(string $recipeDietTypeId): RecipeInterface
    {
        $this->recipeDietTypeId = $recipeDietTypeId;

        return $this;
    }

    public function setSeason(string $season): RecipeInterface
    {
        $this->season = $season;

        return $this;
    }

    public function setBase(string $base): RecipeInterface
    {
        $this->base = $base;

        return $this;
    }

    public function setProteinSource(string $proteinSource): RecipeInterface
    {
        $this->proteinSource = $proteinSource;

        return $this;
    }

    public function setPreparationTimeMinutes(int $preparationTimeMinutes): RecipeInterface
    {
        $this->preparationTimeMinutes = $preparationTimeMinutes;

        return $this;
    }

    public function setShelfLifeDays(int $shelfLifeDays): RecipeInterface
    {
        $this->shelfLifeDays = $shelfLifeDays;

        return $this;
    }

    public function setEquipmentNeeded(string $equipmentNeeded): RecipeInterface
    {
        $this->equipmentNeeded = $equipmentNeeded;

        return $this;
    }

    public function setOriginCountry(string $originCountry): RecipeInterface
    {
        $this->originCountry = $originCountry;

        return $this;
    }

    public function setRecipeCuisine(string $recipeCuisine): RecipeInterface
    {
        $this->recipeCuisine = $recipeCuisine;

        return $this;
    }

    public function setInYourBox(string $inYourBox): RecipeInterface
    {
        $this->inYourBox = $inYourBox;

        return $this;
    }

    public function setGoustoReference(int $goustoReference): RecipeInterface
    {
        $this->goustoReference = $goustoReference;

        return $this;
    }
}
