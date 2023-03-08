<?php

declare(strict_types=1);

use Mazin\Replicate\Exceptions\ReplicateException;
use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Replicate;

class Example
{
    public function exampleCreateAPrediction(): void
    {
        $replicate = new Replicate('token');

        try {
            $prediction = $replicate->createPrediction(
                version: 'v1',
                input: ['foo' => 'bar'],
            );

            echo $prediction->id;
        } catch (ReplicateException|ReplicateWebhookInputException|ResponseException $e) {
        }
    }

    public function exampleGetAPrediction(): void
    {
        $replicate = new Replicate('token');

        try {
            $prediction = $replicate->prediction('prediction-id');

            echo $prediction->id;
        } catch (ReplicateException|ResponseException $e) {
        }
    }
    public function examplePredictions(): void
    {
        $replicate = new Replicate('token');

        try {
            $predictions = $replicate->predictions();

            if ($predictions->next) {
                $nextUrl = $predictions->next;
                $query = parse_url($nextUrl, PHP_URL_QUERY);
                parse_str($query, $params);
                $cursor = $params['cursor'];
                $predictions = $replicate->predictions($cursor);
            }
        } catch (ReplicateException|ResponseException $e) {
        }
    }

    public function exampleCancelAPrediction(): void
    {
        $replicate = new Replicate('token');

        try {
            $replicate->cancelPrediction('prediction-id');
        } catch (ReplicateException|ResponseException $e) {
        }
    }
}