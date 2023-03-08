<?php

declare(strict_types=1);

namespace Mazin\Replicate\Validators;

use Mazin\Replicate\Exceptions\ReplicateWebhookInputException;

class ReplicateWebhookValidator
{
    /**
     * Validates webhook config and it's key values.
     *
     * @param array $input
     * @return array
     * @throws ReplicateWebhookInputException
     */
    public function validate(array $input): array
    {
        $filteredWebhookConfig = $this->validateWebhookConfig($input);

        $this->validateWebhookUrl($filteredWebhookConfig['webhook']);
        $this->validateWebhookEventFilters($filteredWebhookConfig['webhook_events_filter']);

        return [
            'webhook' => $filteredWebhookConfig['webhook'],
            'webhook_events_filter' => $filteredWebhookConfig['webhook_events_filter']
        ];
    }

    /**
     * Validates webhook config.
     *
     * @param array $input
     * @return array
     * @throws ReplicateWebhookInputException
     */
    private function validateWebhookConfig(array $input): array
    {
        $allowedWebhookConfigKeys = ['webhook', 'webhook_events_filter'];

        $filteredWebhookConfig = array_filter(
            $input,
            static fn($key) => in_array($key, $allowedWebhookConfigKeys, true),
            ARRAY_FILTER_USE_KEY
        );

        if (count($filteredWebhookConfig) !== count($input)) {
            throw new ReplicateWebhookInputException(
                'Invalid webhook config provided. Allowed keys: ' . implode(', ', $allowedWebhookConfigKeys)
            );
        }

        return $filteredWebhookConfig;
    }

    /**
     * Validates webhook url.
     *
     * @param string $url
     * @return void
     * @throws ReplicateWebhookInputException
     */
    private function validateWebhookUrl(string $url): void
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new ReplicateWebhookInputException('Invalid webhook url provided.');
        }
    }

    /**
     * Validates webhook event filters.
     *
     * @param array $filters
     * @return void
     * @throws ReplicateWebhookInputException
     */
    private function validateWebhookEventFilters(array $filters): void
    {
        $allowedWebhookEventFilters = ['start', 'output', 'logs', 'completed'];
        $disallowedWebhookEventFilters = array_diff($filters, $allowedWebhookEventFilters);

        if (count($disallowedWebhookEventFilters) > 0) {
            throw new ReplicateWebhookInputException(
                'Invalid webhook event filter provided. Allowed values: ' . implode(', ', $allowedWebhookEventFilters)
            );
        }
    }
}
