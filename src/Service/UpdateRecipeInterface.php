<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface UpdateRecipeInterface
{
    public function handle(int $id, Request $request): Response;
}
