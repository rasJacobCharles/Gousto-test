<?php

declare(strict_types=1);

namespace App\Factory;

use App\Model\PaginatedCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginationFactory implements PaginationFactoryInterface
{
    const ROUTE_NAME = 'get_recipes';
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function create(ArrayCollection $arrayCollection, Request $request): PaginatedCollection
    {
        $page = (int) $request->query->get('page', 1);
        $adapter = new DoctrineCollectionAdapter($arrayCollection);
        $paginationService = new Pagerfanta($adapter);
        $paginationService->setMaxPerPage(10);
        $paginationService->setCurrentPage($page);
        $paginatedCollection = new PaginatedCollection(
            $paginationService->getCurrentPageResults(),
            $paginationService->getNbResults(),
            $page
        );

        $paginatedCollection->addLink('self', $this->createLink($page));
        $paginatedCollection->addLink('first', $this->createLink(1));
        $paginatedCollection->addLink('last', $this->createLink($paginationService->getNbPages()));
        if ($paginationService->hasNextPage()) {
            $paginatedCollection->addLink('next', $this->createLink($paginationService->getNextPage()));
        }
        if ($paginationService->hasPreviousPage()) {
            $paginatedCollection->addLink('prev', $this->createLink($paginationService->getPreviousPage()));
        }

        return $paginatedCollection;
    }

    private function createLink(int $targetPage): string
    {
        return $this->router->generate(self::ROUTE_NAME, ['page' => $targetPage], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
