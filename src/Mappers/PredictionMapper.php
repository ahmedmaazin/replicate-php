<?php

declare(strict_types=1);

namespace Mazin\Replicate\Mappers;

use DateTimeImmutable;
use Mazin\Replicate\Model\Prediction;

class PredictionMapper
{
    /**
     * Map the response from the API to a Prediction object.
     *
     * @param array $data
     *
     * @return Prediction
     */
    public function map(array $data): Prediction
    {
        return new Prediction(
            id: $data['id'],
            version: $data['version'],
            urls: $data['urls'],
            status: $data['status'],
            input: $data['input'],
            created_at: DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']),
            started_at: $data['started_at'] ? DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['started_at']) : null,
            completed_at: $data['completed_at'] ? DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['completed_at']) : null,
            source: $data['source'] ?? null,
            output: $data['output'] ?? null,
            logs: $data['logs'] ?? null,
            metrics: $data['metrics'] ?? null,
            error: $data['error'] ?? null
        );
    }
}