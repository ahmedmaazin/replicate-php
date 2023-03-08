<?php

declare(strict_types=1);

namespace Mazin\Replicate\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Mazin\Replicate\Exceptions\ReplicateException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Mappers\PredictionMapper;
use Mazin\Replicate\Model\Prediction;

class CancelPredictionCommand
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * Cancel a prediction.
     *
     * @param string $predictionId
     *
     * @return Prediction
     * @throws ReplicateException
     * @throws ResponseException
     */
    public function handle(string $predictionId): Prediction
    {
        try {
            $response = $this->client->post('predictions/' . $predictionId . '/cancel');

            $predictionMapper = new PredictionMapper();

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return $predictionMapper->map($data);
        } catch (GuzzleException $guzzleException) {
            throw new ReplicateException($guzzleException->getMessage(), $guzzleException->getCode(), $guzzleException);
        } catch (JsonException $jsonException) {
            throw new ResponseException($jsonException);
        }
    }
}
