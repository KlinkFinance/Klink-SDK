<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Types;

class Config
{
    private string $apiKey;
    private ?string $apiSecret;
    private string $baseUrl;
    private int $timeoutMs;
    private bool $debug;

    public function __construct(array $config)
    {
        $this->apiKey = $config['apiKey'] ?? '';
        $this->apiSecret = $config['apiSecret'] ?? null;
        $this->baseUrl = $config['baseUrl'] ?? 'https://klink-quest.klink.finance/api';
        $this->timeoutMs = $config['timeoutMs'] ?? 8000;
        $this->debug = $config['debug'] ?? false;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getApiSecret(): ?string
    {
        return $this->apiSecret;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getTimeoutMs(): int
    {
        return $this->timeoutMs;
    }

    public function isDebug(): bool
    {
        return $this->debug;
    }
}
