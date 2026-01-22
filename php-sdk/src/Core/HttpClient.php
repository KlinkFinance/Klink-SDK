<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use KlinkFinance\SDK\Types\Config;
use KlinkFinance\SDK\Types\KlinkAPIException;
use KlinkFinance\SDK\Types\KlinkAuthException;
use KlinkFinance\SDK\Types\KlinkNetworkException;
use KlinkFinance\SDK\Utils\Logger;

class HttpClient
{
    private Config $config;
    private Logger $logger;
    private Client $client;

    public function __construct(Config $config, Logger $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->client = new Client([
            'base_uri' => $config->getBaseUrl(),
            'timeout' => $config->getTimeoutMs() / 1000,
            'verify' => true,
        ]);
    }

    /**
     * Make a GET request
     */
    public function get(string $path, array $params = []): array
    {
        return $this->request('GET', $path, ['query' => $params]);
    }

    /**
     * Make a POST request
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request('POST', $path, ['json' => $data]);
    }

    /**
     * Make HTTP request with error handling
     */
    private function request(string $method, string $path, array $options = []): array
    {
        $headers = $this->buildHeaders();
        $options['headers'] = $headers;

        $this->logger->debug("Making {$method} request", [
            'path' => $path,
            'options' => $options,
        ]);

        try {
            $response = $this->client->request($method, $path, $options);
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();

            $this->logger->debug("Response received", [
                'statusCode' => $statusCode,
                'body' => $body,
            ]);

            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new KlinkAPIException(
                    'Invalid JSON response from API',
                    $statusCode
                );
            }

            return $data;
        } catch (GuzzleException $e) {
            $this->logger->error("Request failed", [
                'error' => $e->getMessage(),
            ]);

            $statusCode = $e->getCode();

            if ($statusCode === 401 || $statusCode === 403) {
                throw new KlinkAuthException(
                    'Authentication failed. Please check your API credentials.',
                    $statusCode,
                    $e
                );
            }

            if ($statusCode >= 400 && $statusCode < 500) {
                throw new KlinkAPIException(
                    "API error: {$e->getMessage()}",
                    $statusCode
                );
            }

            if ($statusCode >= 500) {
                throw new KlinkAPIException(
                    "Server error: {$e->getMessage()}",
                    $statusCode
                );
            }

            throw new KlinkNetworkException(
                "Network error: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    /**
     * Build request headers
     */
    private function buildHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->config->getApiKey(),
        ];

        if ($this->config->getApiSecret()) {
            $headers['X-API-Secret'] = $this->config->getApiSecret();
        }

        return $headers;
    }
}
