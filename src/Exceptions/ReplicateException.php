<?php

declare(strict_types=1);

namespace Mazin\Replicate\Exceptions;

use Exception;
use InvalidArgumentException;
use Throwable;

class ReplicateException extends Exception
{
    /**
     * Creates a new Exception instance.
     *
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (!($previous instanceof Throwable)) {
            throw new InvalidArgumentException('ReplicateException constructor requires a previous Throwable');
        }
        parent::__construct($message, $code, $previous);
    }
}
