<?php

declare(strict_types=1);

namespace App\Model;


interface RecipeInterface
{
    public function setId(int $id): RecipeInterface;

    public function setTitle(string $title): RecipeInterface;

    public function setMarketingDescription(string $marketingDescription): RecipeInterface;
}