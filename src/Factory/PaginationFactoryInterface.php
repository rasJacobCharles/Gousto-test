<?php

declare(strict_types=1);

namespace App\Factory;

use App\Model\PaginatedCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

interface PaginationFactoryInterface
{
    public function create(ArrayCollection $arrayCollection, Request $request): PaginatedCollection;
}
