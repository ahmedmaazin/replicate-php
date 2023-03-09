<?php

declare(strict_types=1);

namespace Mazin\Replicate\Tests\Fixtures;

final class PredictionDataFixture
{
    public static function get(): array
    {
        return [
            'id' => '1',
            'version' => 'v1',
            'urls' => [
                'get' => 'https://api.replicate.com/v1/predictions/foo',
                'cancel' => 'https://api.replicate.com/v1/predictions/foo/cancel',
            ],
            'status' => 'succeeded',
            'input' => [
                'prompt' => 'foo',
            ],
            'created_at' => '2022-01-01T01:23:45.678900Z',
            'started_at' => '2022-01-01T01:23:46.678900Z',
            'completed_at' => '2022-01-01T01:23:47.678900Z',
            'source' => 'api',
            'output' => [
                "https://replicate.delivery/pbxt/foo/out-0.png"
            ],
            'logs' => "Using seed",
            'metrics' => [
                'predict_time' => 0.95,
            ],
            'error' => null,
        ];
    }
}