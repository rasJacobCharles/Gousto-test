<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GetRecipeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1")
 */
class GetRecipeController extends AbstractController
{
    /**
     * @var GetRecipeInterface
     */
    private $getRecipe;

    public function __construct(GetRecipeInterface $getRecipe)
    {
        $this->getRecipe = $getRecipe;
    }

    /**
     * @Route("/recipes/{id}", name="get_recipe", methods={"GET"})
     */
    public function handle(int $id): Response
    {
        return $this->getRecipe->handle($id);
    }
}
