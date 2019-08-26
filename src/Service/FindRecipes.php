<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\PaginationFactoryInterface;
use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\FilteredRecipe;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FindRecipes implements FindRecipesInterface
{
    private $collectionFactory;
    private $paginationFactory;

    public function __construct(RecipeCollectionFactoryInterface $collectionFactory, PaginationFactoryInterface $paginationFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->paginationFactory = $paginationFactory;
    }

    public function handle(Request $request): Response
    {
        try {
            return (new JsonResponse(
                $this->paginationFactory->create(
                    $this->collectionFactory->getCollection(
                        RecipeCollectionFactoryInterface::CSV_FILENAME,
                        FilteredRecipe::class
                    ),
                    $request
                )
            ))->setEncodingOptions(JSON_PRETTY_PRINT);
        } catch (OutOfRangeCurrentPageException $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
