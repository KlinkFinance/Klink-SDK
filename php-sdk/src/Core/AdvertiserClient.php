<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Core;

use KlinkFinance\SDK\Utils\Logger;

class AdvertiserClient
{
    private HttpClient $httpClient;
    private Logger $logger;
    private string $apiKey;

    public function __construct(HttpClient $httpClient, Logger $logger, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->apiKey = $apiKey;
    }

    /**
     * Health check
     */
    public function healthCheck(): array
    {
        $this->logger->info('Performing health check');
        return $this->httpClient->get('/health');
    }

    /**
     * Send postback
     */
    public function sendPostback(array $data): array
    {
        // Validate required fields
        $requiredFields = [
            'event_name',
            'offer_id',
            'sub1',
            'tx_id',
            'isChargeback',
            'chargebackReason',
            'isTest'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        $this->logger->info('Sending postback', $data);
        
        // Use apiKey as advertiserId in the route
        return $this->httpClient->post(
            "/v1/advertiser/{$this->apiKey}/postback",
            $data
        );
    }
}
