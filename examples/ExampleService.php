<?php

declare(strict_types=1);

use Mazin\Replicate\Exceptions\ReplicateException;
use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Replicate;

class ExampleService
{
    private Replicate $replicate;

    public function __construct()
    {
        $this->replicate = new Replicate(apiToken: 'api-token');
    }

    public function exampleCreateAPrediction(): void
    {
        try {
            $prediction = $this->replicate->createPrediction(
                version: 'v1',
                input: ['text' => 'foo'],
            );

            echo $prediction->id;
        } catch (ReplicateException|ReplicateWebhookInputException|ResponseException $e) {
        }
    }

    public function exampleGetAPrediction(): void
    {
        try {
            $prediction = $this->replicate->prediction(predictionId: 'prediction-id');

            echo $prediction->id;
        } catch (ReplicateException|ResponseException $e) {
        }
    }

    public function examplePredictions(): void
    {
        try {
            $predictions = $this->replicate->predictions();

            // if you would like to paginate.
            if ($predictions->next) {
                $nextUrl = $predictions->next;
                $query = parse_url($nextUrl, PHP_URL_QUERY);
                parse_str($query, $params);
                $cursor = $params['cursor'];
                $predictions = $this->replicate->predictions(cursor: $cursor);
                // $predictions->results;
            }
        } catch (ReplicateException|ResponseException $e) {
        }
    }

    public function exampleCancelAPrediction(): void
    {
        try {
            $response = $this->replicate->cancelPrediction(predictionId: 'prediction-id');

            echo $response->status;
        } catch (ReplicateException|ResponseException $e) {
        }
    }
}
