<?php

declare(strict_types=1);

namespace Mazin\Replicate\Tests\Commands;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mazin\Replicate\Commands\GetPredictionCommand;
use Mazin\Replicate\Tests\Fixtures\PredictionDataFixture;
use PHPUnit\Framework\TestCase;

class GetPredictionCommandTest extends TestCase
{
    public function test_get_prediction_command(): void
    {
        $responseBody = json_encode(PredictionDataFixture::get(), JSON_THROW_ON_ERROR);

        $mockResponse = new Response(
            200,
            ['Content-Type' => 'application/json'],
            $responseBody
        );

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('predictions/1')
            ->willReturn($mockResponse);

        $command = new GetPredictionCommand($mockClient);
        $result = $command->handle('1');

        $this->assertSame('1', $result->id);
        $this->assertSame('v1', $result->version);
        $this->assertSame([
            'get' => 'https://api.replicate.com/v1/predictions/foo',
            'cancel' => 'https://api.replicate.com/v1/predictions/foo/cancel',
        ], $result->urls);
        $this->assertSame('succeeded', $result->status);
        $this->assertSame([
            'prompt' => 'foo',
        ], $result->input);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', '2022-01-01T01:23:45.678900Z'), $result->created_at);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', '2022-01-01T01:23:46.678900Z'), $result->started_at);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', '2022-01-01T01:23:47.678900Z'), $result->completed_at);
        $this->assertSame('api', $result->source);
        $this->assertSame([
            "https://replicate.delivery/pbxt/foo/out-0.png"
        ], $result->output);
        $this->assertSame("Using seed", $result->logs);
        $this->assertSame([
            'predict_time' => 0.95,
        ], $result->metrics);
        $this->assertNull($result->error);
    }
}