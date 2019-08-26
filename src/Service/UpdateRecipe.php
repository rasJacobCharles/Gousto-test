<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\RecipeCollectionFactoryInterface;
use App\Model\Recipe;
use App\Model\UpdateRecipeRequest;
use App\Utility\ArrayCollectionTrait;
use App\Utility\CSVRecipeUpdateUtility;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Throwable;

class UpdateRecipe implements UpdateRecipeInterface
{
    use ArrayCollectionTrait;

    const ERROR_MESSAGE = 'Id does not refer to exist record.';
    /**
     * @var RecipeCollectionFactoryInterface
     */
    private $collectionFactory;
    /**
     * @var Serializer
     */
    private $serializer;
    /**
     * @var string
     */
    private $filename;

    public function __construct(
        RecipeCollectionFactoryInterface $collectionFactory,
        Serializer $serializer,
        string $filename = RecipeCollectionFactoryInterface::CSV_FILENAME
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->serializer = $serializer;
        $this->filename = $filename;
    }

    public function handle(int $id, Request $request): Response
    {
        $collection = $this->collectionFactory->getCollection();

        $exist = $collection->exists(function ($key, $element) use ($id) {
            if ($id === $element->id) {
                return true;
            }
            return false;
        });

        if (!$exist) {
            return new Response(self::ERROR_MESSAGE, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->save(
                $this->updateRecord(
                    $this->createUpdateRecipeRequest($request),
                    $record = $collection->get($this->getKey($id, $collection))
                ),
                $collection
            );

            return (new JsonResponse($this->serializer->serialize($record, 'json')))->setEncodingOptions(JSON_PRETTY_PRINT);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createUpdateRecipeRequest(Request $request): UpdateRecipeRequest
    {
        return $this->serializer->deserialize($request->getContent(), UpdateRecipeRequest::class, 'json');
    }

    private function updateRecord(UpdateRecipeRequest $updateRequest, Recipe $recipe): Recipe
    {
        foreach (get_class_methods($updateRequest) as $methodName) {
            if (null !== $updateRequest->$methodName()) {
                $setMethod = str_replace('get', 'set', $methodName);
                $recipe->$setMethod($updateRequest->$methodName());
            }
        }

        return $recipe;
    }

    private function save(Recipe $recipe, ArrayCollection $arrayCollection): void
    {
        $service = new CSVRecipeUpdateUtility($arrayCollection, $this->serializer);
        $service->update($recipe);
        $service->save($this->filename);
    }
}
