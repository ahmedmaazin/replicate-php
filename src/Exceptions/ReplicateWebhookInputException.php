<?php

declare(strict_types=1);

namespace Mazin\Replicate\Exceptions;

use Exception;

class ReplicateWebhookInputException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}