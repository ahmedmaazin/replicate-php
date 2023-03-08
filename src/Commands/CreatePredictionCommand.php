<?php

declare(strict_types=1);

namespace Mazin\Replicate\Commands;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Mazin\Replicate\Exceptions\ReplicateException;
use JsonException;
use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Mappers\PredictionMapper;
use Mazin\Replicate\Model\Prediction;
use Mazin\Replicate\Validators\ReplicateWebhookValidator;

class CreatePredictionCommand
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Handle the command.
     *
     * @param string $version
     * @param array $input
     * @param array|null $webhookConfig
     * @return Prediction
     * @throws ReplicateException
     * @throws ReplicateWebhookInputException
     * @throws ResponseException
     */
    public function handle(string $version, array $input, ?array $webhookConfig = null): Prediction
    {
        $body = $this->processBody($version, $input, $webhookConfig);

        try {
            $response = $this->client->post('predictions', [
                'json' => $body,
            ]);

            $predictionMapper = new PredictionMapper();

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return $predictionMapper->map($data);
        } catch (GuzzleException $guzzleException) {
            throw new ReplicateException($guzzleException->getMessage(), $guzzleException->getCode(), $guzzleException);
        } catch (JsonException $jsonException) {
            throw new ResponseException($jsonException);
        }
    }

    /**
     * Process the body of the request.
     *
     * @param string $version
     * @param array $input
     * @param array|null $webhookConfig
     *
     * @return array
     * @throws ReplicateWebhookInputException
     */
    private function processBody(string $version, array $input, ?array $webhookConfig = null): array
    {
        $body = [
            'version' => $version,
            'input' => $input
        ];

        if ($webhookConfig !== null) {
            $webhookValidator = new ReplicateWebhookValidator();
            $validWebhookConfig = $webhookValidator->validate($webhookConfig);

            $body['webhook'] = $validWebhookConfig['webhook'];
            $body['webhook_events_filter'] = $validWebhookConfig['webhook_events_filter'];
        }

        return $body;
    }
}