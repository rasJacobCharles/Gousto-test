<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use App\Model\RecipeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetRecipe implements GetRecipeInterface
{
    private $collectionFactory;

    public function __construct(RecipeCollectionFactoryInterface $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function handle(int $id): Response
    {
        try {
            return (new JsonResponse($this->getRecord($id)))->setEncodingOptions(JSON_PRETTY_PRINT);
        } catch (NotFoundHttpException $exception) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }
    }

    private function getRecord(int $id): RecipeInterface
    {
        foreach ($this->collectionFactory->getCollection() as $value) {
            /** @var Recipe $value */
            if ($value->id === $id) {
                return $value;
            }
        }

        throw new NotFoundHttpException('Unable to find resource.');
    }
}
