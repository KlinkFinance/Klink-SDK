<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Core;

use KlinkFinance\SDK\Types\KlinkConfigException;
use KlinkFinance\SDK\Utils\Logger;

class PublisherClient
{
    private HttpClient $httpClient;
    private Logger $logger;
    private ?string $apiSecret;

    public function __construct(HttpClient $httpClient, Logger $logger, ?string $apiSecret)
    {
        if (empty($apiSecret)) {
            throw new KlinkConfigException(
                'API secret is required for Publisher API access'
            );
        }

        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Fetch offers with optional filters
     */
    public function getOffers(array $params = []): array
    {
        $this->logger->info('Fetching offers', $params);
        return $this->httpClient->get('/v1/publisher/offers', $params);
    }

    /**
     * Fetch conversions with optional filters
     */
    public function getConversions(array $params = []): array
    {
        $this->logger->info('Fetching conversions', $params);
        return $this->httpClient->get('/v1/publisher/conversions', $params);
    }

    /**
     * Fetch publisher users
     */
    public function getUsers(array $params = []): array
    {
        $this->logger->info('Fetching users', $params);
        return $this->httpClient->get('/v1/publisher/users', $params);
    }

    /**
     * Fetch postback logs
     */
    public function getPostbacks(array $params = []): array
    {
        $this->logger->info('Fetching postbacks', $params);
        return $this->httpClient->get('/v1/publisher/postbacks', $params);
    }

    /**
     * Fetch supported countries
     */
    public function getCountries(bool $reload = false): array
    {
        $params = $reload ? ['reload' => true] : [];
        $this->logger->info('Fetching countries', $params);
        return $this->httpClient->get('/v1/publisher/countries', $params);
    }

    /**
     * Fetch supported categories
     */
    public function getCategories(bool $reload = false): array
    {
        $params = $reload ? ['reload' => true] : [];
        $this->logger->info('Fetching categories', $params);
        return $this->httpClient->get('/v1/publisher/categories', $params);
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
     * Send test postback
     */
    public function sendTestPostback(array $data): array
    {
        $this->logger->info('Sending test postback', $data);
        return $this->httpClient->post('/v1/publisher/postback/test', $data);
    }
}
