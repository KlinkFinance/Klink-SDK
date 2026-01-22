<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Utils;

use KlinkFinance\SDK\Types\KlinkConfigException;

class Validator
{
    public static function validateConfig(array $config): void
    {
        if (empty($config['apiKey'])) {
            throw new KlinkConfigException('API key is required');
        }

        if (!is_string($config['apiKey'])) {
            throw new KlinkConfigException('API key must be a string');
        }

        if (isset($config['apiSecret']) && !is_string($config['apiSecret'])) {
            throw new KlinkConfigException('API secret must be a string');
        }

        if (isset($config['baseUrl'])) {
            if (!is_string($config['baseUrl'])) {
                throw new KlinkConfigException('Base URL must be a string');
            }
            
            if (!filter_var($config['baseUrl'], FILTER_VALIDATE_URL)) {
                throw new KlinkConfigException('Base URL must be a valid URL');
            }
        }

        if (isset($config['timeoutMs'])) {
            if (!is_int($config['timeoutMs'])) {
                throw new KlinkConfigException('Timeout must be an integer');
            }
            
            if ($config['timeoutMs'] <= 0) {
                throw new KlinkConfigException('Timeout must be positive');
            }
        }

        if (isset($config['debug']) && !is_bool($config['debug'])) {
            throw new KlinkConfigException('Debug must be a boolean');
        }
    }
}
