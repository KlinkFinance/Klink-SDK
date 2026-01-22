<?php

declare(strict_types=1);

namespace KlinkFinance\SDK;

use KlinkFinance\SDK\Core\AdvertiserClient;
use KlinkFinance\SDK\Core\HttpClient;
use KlinkFinance\SDK\Core\PublisherClient;
use KlinkFinance\SDK\Types\Config;
use KlinkFinance\SDK\Utils\Logger;
use KlinkFinance\SDK\Utils\Validator;

class KlinkSDK
{
    private Config $config;
    private Logger $logger;
    private HttpClient $httpClient;
    private ?PublisherClient $publisherClient = null;
    private ?AdvertiserClient $advertiserClient = null;

    private function __construct(Config $config)
    {
        $this->config = $config;
        $this->logger = new Logger($config->isDebug());
        $this->httpClient = new HttpClient($config, $this->logger);

        $this->logger->info('Klink SDK initialized', [
            'baseUrl' => $config->getBaseUrl(),
            'debug' => $config->isDebug(),
        ]);
    }

    /**
     * Create SDK instance with health check
     * 
     * @param array $config Configuration array
     * @return self
     * @throws \Exception If health check fails
     */
    public static function create(array $config): self
    {
        // Validate configuration
        Validator::validateConfig($config);

        // Create temporary instance for health check
        $configObj = new Config($config);
        $logger = new Logger($configObj->isDebug());
        $httpClient = new HttpClient($configObj, $logger);

        // Perform health check
        try {
            $logger->info('Performing health check before initialization');
            $health = $httpClient->get('/health');
            
            if (!isset($health['status']) || $health['status'] !== 'ok') {
                throw new \Exception('Health check failed: Invalid status');
            }
            
            $logger->info('Health check passed');
        } catch (\Exception $e) {
            $logger->error('Health check failed', [
                'error' => $e->getMessage(),
            ]);
            throw new \Exception("Failed to initialize SDK: {$e->getMessage()}", 0, $e);
        }

        // Create and return SDK instance
        return new self($configObj);
    }

    /**
     * Get Publisher client
     * 
     * @return PublisherClient
     * @throws \Exception If API secret is not configured
     */
    public function publisher(): PublisherClient
    {
        if ($this->publisherClient === null) {
            $this->publisherClient = new PublisherClient(
                $this->httpClient,
                $this->logger,
                $this->config->getApiSecret()
            );
        }

        return $this->publisherClient;
    }

    /**
     * Get Advertiser client
     * 
     * @return AdvertiserClient
     */
    public function advertiser(): AdvertiserClient
    {
        if ($this->advertiserClient === null) {
            $this->advertiserClient = new AdvertiserClient(
                $this->httpClient,
                $this->logger,
                $this->config->getApiKey()
            );
        }

        return $this->advertiserClient;
    }
}
