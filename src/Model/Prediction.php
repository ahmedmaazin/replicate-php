<?php

declare(strict_types=1);

namespace Mazin\Replicate\Model;

use DateTimeImmutable;

class Prediction
{
    public function __construct(
        public string  $id,
        public string  $version,
        public array   $urls,
        public string  $status,
        public array   $input,
        public DateTimeImmutable  $created_at,
        public ?DateTimeImmutable  $started_at,
        public ?DateTimeImmutable  $completed_at,
        public ?string  $source,
        public ?array   $output,
        public ?string  $logs,
        public ?array   $metrics,
        public ?string $error,
    )
    {
    }
}