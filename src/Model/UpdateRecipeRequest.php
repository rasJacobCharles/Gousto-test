<?php

declare(strict_types=1);

namespace App\Model;

class UpdateRecipeRequest
{
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


    public function getBoxType(): ?string
    {
        return $this->boxType;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function getMarketingDescription(): ?string
    {
        return $this->marketingDescription;
    }

    public function getCaloriesKcal(): ?int
    {
        return $this->caloriesKcal;
    }

    public function getProteinGrams(): ?int
    {
        return $this->proteinGrams;
    }

    public function getFatGrams(): ?int
    {
        return $this->fatGrams;
    }

    public function getCarbsGrams(): ?int
    {
        return $this->carbsGrams;
    }

    public function getBulletpoint1(): ?string
    {
        return $this->bulletpoint1;
    }

    public function getBulletpoint2(): ?string
    {
        return $this->bulletpoint2;
    }

    public function getBulletpoint3(): ?string
    {
        return $this->bulletpoint3;
    }

    public function getRecipeDietTypeId(): ?string
    {
        return $this->recipeDietTypeId;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function getProteinSource(): ?string
    {
        return $this->proteinSource;
    }

    public function getPreparationTimeMinutes(): ?int
    {
        return $this->preparationTimeMinutes;
    }

    public function getShelfLifeDays(): ?int
    {
        return $this->shelfLifeDays;
    }

    public function getEquipmentNeeded(): ?string
    {
        return $this->equipmentNeeded;
    }

    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    public function getRecipeCuisine(): ?string
    {
        return $this->recipeCuisine;
    }

    public function getInYourBox(): ?string
    {
        return $this->inYourBox;
    }

    public function getGoustoReference(): ?int
    {
        return $this->goustoReference;
    }
}
