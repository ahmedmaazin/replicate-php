<?php

declare(strict_types=1);

namespace Mazin\Replicate;

use GuzzleHttp\Client;
use Mazin\Replicate\Commands\CancelPredictionCommand;
use Mazin\Replicate\Commands\CreatePredictionCommand;
use Mazin\Replicate\Commands\GetPredictionCommand;
use Mazin\Replicate\Commands\GetPredictionsCommand;
use Mazin\Replicate\Exceptions\ReplicateException;
use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Model\Prediction;
use Mazin\Replicate\Model\Predictions;

class Replicate
{
    private Client $client;

    private const API_VERSION = 'v1';

    private const API_BASE_URL = 'https://api.replicate.com';

    private const USER_AGENT = 'replicate-php@0.0.1';

    /**
     * Create a new Replicate instance.
     *
     * @param string $apiToken
     */
    public function __construct(private readonly string $apiToken)
    {
        $config = [
            'base_uri' => self::API_BASE_URL . '/' . self::API_VERSION . '/',
            'headers' => [
                'Authorization' => 'Token ' . $this->apiToken,
                'User-Agent' => self::USER_AGENT,
            ],
            'timeout' => 15.0,
        ];

        $this->client = new Client($config);
    }

    /**
     * Get a list of predictions.
     *
     * @param string|null $cursor
     *
     * @return Predictions
     * @throws ReplicateException
     * @throws ResponseException
     */
    public function predictions(?string $cursor = null): Predictions
    {
        return (new GetPredictionsCommand($this->client))->handle(cursor: $cursor);
    }

    /**
     * Create a prediction.
     *
     * @param string $version
     * @param array $input
     * @param array|null $webhookConfig
     *
     * @return Prediction
     * @throws ReplicateException
     * @throws ReplicateWebhookInputException
     * @throws ResponseException
     */
    public function createPrediction(
        string $version,
        array  $input,
        ?array $webhookConfig = null): Prediction
    {
        return (new CreatePredictionCommand($this->client))->handle($version, $input, $webhookConfig);
    }

    /**
     * Get a prediction by ID.
     *
     * @param string $predictionId
     *
     * @return Prediction
     * @throws ReplicateException
     * @throws ResponseException
     */
    public function prediction(string $predictionId): Prediction
    {
        return (new GetPredictionCommand($this->client))->handle($predictionId);
    }

    /**
     * Cancel a prediction by ID.
     *
     * @param string $predictionId
     *
     * @return Prediction
     * @throws ReplicateException
     * @throws ResponseException
     */
    public function cancelPrediction(string $predictionId): Prediction
    {
        return (new CancelPredictionCommand($this->client))->handle($predictionId);
    }
}
