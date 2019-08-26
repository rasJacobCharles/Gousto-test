<?php

declare(strict_types=1);

namespace App\Model;

class PaginatedCollection
{
    public $result;
    public $numberOfResult;
    public $pageNumber;
    public $links = [];

    public function __construct(array $result, int $numberOfResult, int $pageNumber)
    {
        $this->result = $result;
        $this->numberOfResult = $numberOfResult;
        $this->pageNumber = $pageNumber;
    }

    public function addLink(string $name, string $url): PaginatedCollection
    {
        $this->links[$name] = $url;

        return $this;
    }
}
