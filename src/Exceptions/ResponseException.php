<?php

declare(strict_types=1);

namespace Mazin\Replicate\Exceptions;

use Exception;
use JsonException;

class ResponseException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param JsonException $exception
     */
    public function __construct(JsonException $exception)
    {
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
