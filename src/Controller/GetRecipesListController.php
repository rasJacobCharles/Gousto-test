<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FindRecipesInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1")
 */
class GetRecipesListController extends AbstractController
{
    private $service;

    public function __construct(FindRecipesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/recipes", name="get_recipes", methods={"GET"})
     */
    public function handle(Request $request): Response
    {
        return $this->service->handle($request);
    }
}
