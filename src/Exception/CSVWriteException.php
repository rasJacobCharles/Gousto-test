<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\DependencyInjection\Exception\ExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class CSVWriteException extends HttpException implements ExceptionInterface
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct(500, $message, $previous);
    }
}
