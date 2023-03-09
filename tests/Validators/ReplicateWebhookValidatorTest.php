<?php

declare(strict_types=1);

namespace Mazin\Replicate\Tests\Validators;

use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;
use Mazin\Replicate\Validators\ReplicateWebhookValidator;
use PHPUnit\Framework\TestCase;

class ReplicateWebhookValidatorTest extends TestCase
{
    public function test_validate(): void
    {
        $validator = new ReplicateWebhookValidator();

        $input = [
            'webhook' => 'https://example.com',
            'webhook_events_filter' => ['start', 'output', 'logs', 'completed']
        ];
        $expectedResult = [
            'webhook' => 'https://example.com',
            'webhook_events_filter' => ['start', 'output', 'logs', 'completed']
        ];
        $this->assertSame($expectedResult, $validator->validate($input));
    }

    public function test_validate_with_missing_key(): void
    {
        $validator = new ReplicateWebhookValidator();

        $input = [
            'webhook' => 'https://example.com',
        ];
        $this->expectException(ReplicateWebhookInputException::class);
        $validator->validate($input);
    }

    public function test_validate_with_extra_key(): void
    {
        $validator = new ReplicateWebhookValidator();

        $input = [
            'webhook' => 'https://example.com',
            'webhook_events_filter' => ['start', 'output', 'logs', 'completed'],
            'extra_key' => 'extra_value'
        ];
        $this->expectException(ReplicateWebhookInputException::class);
        $validator->validate($input);
    }

    public function test_validate_with_invalid_webhook_url(): void
    {
        $validator = new ReplicateWebhookValidator();

        $input = [
            'webhook' => 'invalid_url',
            'webhook_events_filter' => ['start', 'output', 'logs', 'completed']
        ];
        $this->expectException(ReplicateWebhookInputException::class);
        $validator->validate($input);
    }

    public function test_validate_with_invalid_webhook_event_filter(): void
    {
        $validator = new ReplicateWebhookValidator();

        $input = [
            'webhook' => 'https://example.com',
            'webhook_events_filter' => ['start', 'output', 'invalid_filter', 'completed']
        ];
        $this->expectException(ReplicateWebhookInputException::class);
        $validator->validate($input);
    }
}
