<?php

declare(strict_types=1);

namespace Mazin\Replicate\Model;

use Mazin\Replicate\Mappers\PredictionMapper;

class Predictions
{
    public function __construct(
        public ?string $previous,
        public ?string $next,
        public array   $results,
    )
    {
    }

    public static function fromApiResponse(array $response): self
    {
        $predictions = [];

        foreach ($response['results'] as $predictionData) {
            $predictionMapper = new PredictionMapper();
            $prediction = $predictionMapper->map($predictionData);
            $predictions[] = $prediction;
        }

        return new self(
            $response['previous'],
            $response['next'],
            $predictions
        );
    }
}