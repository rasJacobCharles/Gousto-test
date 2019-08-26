<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model;

use App\Model\Recipe;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RecipeTest extends TestCase
{
    private $jsonData = <<<JSON
{
	"id": 2,
	"created_at": "30/06/2015 17:58:00",
	"updated_at": "30/06/2015 17:58:00",
	"box_type": "gourmet",
	"title": "Tamil Nadu Prawn Masala",
	"slug": "tamil - nadu - prawn - masala",
	"marketing_description": "Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed",
	"calories_kcal": 524,
	"protein_grams": 12,
	"fat_grams": 22,
	"carbs_grams": 0,
	"bulletpoint1": "Vibrant & Fresh",
	"bulletpoint2": "Warming, not spicy",
	"bulletpoint3": "Curry From Scratch",
	"recipe_diet_type_id": "fish",
	"season": "all",
	"base": "pasta",
	"protein_source": "seafood",
	"preparation_time_minutes": 40,
	"shelf_life_days": 4,
	"equipment_needed": "Appetite",
	"origin_country": "Great Britain",
	"recipe_cuisine": "italian",
	"in_your_box": "king prawns, basmati rice, onion, tomatoes, garlic, ginger, ground tumeric, red chilli powder, ground cumin, fresh coriander, curry leaves, fennel seeds",
	"gousto_reference": 58
}
JSON;

    /**@var Serializer */
    private $serializer;

    protected function setUp(): void
    {
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function testDeserializeJsonAsObject(): void
    {
        $expectResult = new Recipe();
        $expectResult
            ->setId(2)
            ->setCreatedAt("30/06/2015 17:58:00")
            ->setUpdatedAt("30/06/2015 17:58:00")
            ->setBoxType("gourmet")
            ->setTitle("Tamil Nadu Prawn Masala")
            ->setSlug("tamil - nadu - prawn - masala")
            ->setMarketingDescription("Tamil Nadu is a state on the eastern coast of the southern tip of India. Curry from there is particularly famous and it's easy to see why. This one is brimming with exciting contrasting tastes from ingredients like chilli powder, coriander and fennel seed")
            ->setCaloriesKcal(524)
            ->setProteinGrams(12)
            ->setFatGrams(22)
            ->setCarbsGrams(0)
            ->setBulletpoint1("Vibrant & Fresh")
            ->setBulletpoint2("Warming, not spicy")
            ->setBulletpoint3("Curry From Scratch")
            ->setRecipeDietTypeId("fish")
            ->setSeason('all')
            ->setBase('pasta')
            ->setProteinSource("seafood")
            ->setPreparationTimeMinutes(40)
            ->setShelfLifeDays(4)
            ->setEquipmentNeeded("Appetite")
            ->setOriginCountry("Great Britain")
            ->setRecipeCuisine("italian")
            ->setInYourBox("king prawns, basmati rice, onion, tomatoes, garlic, ginger, ground tumeric, red chilli powder, ground cumin, fresh coriander, curry leaves, fennel seeds")
            ->setGoustoReference(58);

        $result = $this->serializer->deserialize($this->jsonData, Recipe::class, 'json');

        $this->assertInstanceOf(Recipe::class, $result);
        $this->assertEquals($expectResult, $result);
    }
}
