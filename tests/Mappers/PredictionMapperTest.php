<?php

declare(strict_types=1);

namespace Mazin\Replicate\Tests\Mappers;

use DateTimeImmutable;
use Mazin\Replicate\Mappers\PredictionMapper;
use Mazin\Replicate\Tests\Fixtures\PredictionDataFixture;
use PHPUnit\Framework\TestCase;

class PredictionMapperTest extends TestCase
{
    private PredictionMapper $predictionMapper;

    protected function setUp(): void
    {
        $this->predictionMapper = new PredictionMapper();
    }

    public function test_map_maps_properly(): void
    {
        $data = PredictionDataFixture::get();

        $prediction = $this->predictionMapper->map($data);

        $this->assertSame('1', $prediction->id);
        $this->assertSame('v1', $prediction->version);
        $this->assertSame($data['urls'], $prediction->urls);
        $this->assertSame('succeeded', $prediction->status);
        $this->assertSame($data['input'], $prediction->input);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at']), $prediction->created_at);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['started_at']), $prediction->started_at);
        $this->assertEquals(DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['completed_at']), $prediction->completed_at);
        $this->assertSame($data['source'], $prediction->source);
        $this->assertSame($data['output'], $prediction->output);
        $this->assertSame($data['logs'], $prediction->logs);
        $this->assertSame($data['metrics'], $prediction->metrics);
        $this->assertSame($data['error'], $prediction->error);
    }
}
