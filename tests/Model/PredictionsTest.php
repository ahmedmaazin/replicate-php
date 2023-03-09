<?php

declare(strict_types=1);

namespace Mazin\Replicate\Tests\Model;

use Mazin\Replicate\Model\Prediction;
use Mazin\Replicate\Model\Predictions;
use Mazin\Replicate\Tests\Fixtures\PredictionsDataFixture;
use PHPUnit\Framework\TestCase;

class PredictionsTest extends TestCase
{
    public function test_from_api_response_sets_proper_data(): void
    {
        $response = PredictionsDataFixture::get();

        $predictions = Predictions::fromApiResponse($response);

        $this->assertEquals('https://api.replicate.com/v1/predictions', $predictions->previous);
        $this->assertEquals('https://api.replicate.com/v1/predictions?cursor=foo', $predictions->next);
        $this->assertCount(2, $predictions->results);
        $this->assertInstanceOf(Prediction::class, $predictions->results[0]);
        $this->assertInstanceOf(Prediction::class, $predictions->results[1]);
        $this->assertEquals('1', $predictions->results[0]->id);
        $this->assertEquals('2', $predictions->results[1]->id);
    }
}