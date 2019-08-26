<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UpdateRecipeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1")
 */
class PatchRecipeController extends AbstractController
{
    /**
     * @var UpdateRecipeInterface
     */
    private $service;

    public function __construct(UpdateRecipeInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/recipes/{id}", name="update_recipe", methods={"PATCH"})
     */
    public function handle(int $id, Request $request): Response
    {
        return $this->service->handle($id, $request);
    }
}
