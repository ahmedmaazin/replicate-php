<?php

namespace Mazin\Replicate\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Mazin\Replicate\Exceptions\ReplicateException;
use Mazin\Replicate\Exceptions\ResponseException;
use Mazin\Replicate\Model\Predictions;

class GetPredictionsCommand
{
    public function __construct(private readonly Client $client)
    {
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
    public function handle(?string $cursor = null): Predictions
    {
        $queryParams = [];

        if (null !== $cursor) {
            $queryParams['cursor'] = $cursor;
        }

        try {
            $response = $this->client->get('predictions', [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return Predictions::fromApiResponse($data);
        } catch (GuzzleException $guzzleException) {
            throw new ReplicateException($guzzleException->getMessage(), $guzzleException->getCode(), $guzzleException);
        } catch (JsonException $jsonException) {
            throw new ResponseException($jsonException);
        }
    }
}
