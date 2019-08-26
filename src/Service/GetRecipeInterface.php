<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

interface GetRecipeInterface
{
    public function handle(int $id): Response;
}
