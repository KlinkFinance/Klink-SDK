<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Core;

use KlinkFinance\SDK\Types\KlinkConfigException;
use KlinkFinance\SDK\Utils\Logger;
use Firebase\JWT\JWT;

class PublisherClient
{
    private HttpClient $httpClient;
    private Logger $logger;

    public function __construct(HttpClient $httpClient, Logger $logger, ?string $apiSecret)
    {
        if (empty($apiSecret)) {
            throw new KlinkConfigException(
                'API secret is required for Publisher API access'
            );
        }

        $this->httpClient = $httpClient;
        $this->logger = $logger;
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

    /**
     * Create a JWT token for quest redirection
     *
     * @param array $params Dictionary containing offerId, sub, pub, etc.
     * @param string $secret JWT secret key
     * @return array Dictionary containing token and expiresAt
     * @throws \InvalidArgumentException If required parameters are missing
     */
    public function createQuestRedirectToken(array $params, string $secret): array
    {
        $this->logger->debug('Creating quest redirect token with params', $params);

        // Validate required parameters
        if (empty($params['offerId']) || empty($params['sub']) || empty($params['pub'])) {
            throw new \InvalidArgumentException('offerId, sub, and pub are required');
        }

        if (empty($secret)) {
            throw new \InvalidArgumentException('JWT secret is required');
        }

        try {
            // Calculate expiration time
            $expirationMinutes = $params['expirationMinutes'] ?? 10;
            $currentTime = time();
            $expiresAt = $currentTime + ($expirationMinutes * 60);

            // Build JWT payload
            $payload = [
                'offerId' => $params['offerId'],
                'exp' => $expiresAt,
                'sub' => $params['sub'],
                'pub' => $params['pub'],
                'iat' => $currentTime
            ];

            // Add custom params if provided
            if (isset($params['custom_params'])) {
                $payload['custom_params'] = $params['custom_params'];
            }

            $this->logger->debug('JWT payload', $payload);

            // Sign the token
            $token = JWT::encode($payload, $secret, 'HS256');

            $this->logger->debug('JWT token created successfully');

            return [
                'token' => $token,
                'expiresAt' => $expiresAt
            ];

        } catch (\Exception $e) {
            $this->logger->error('Error creating quest redirect token', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
