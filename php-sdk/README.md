# Klink Finance PHP SDK

[![Latest Stable Version](https://poser.pugx.org/klinkfinance/sdk/v/stable)](https://packagist.org/packages/klinkfinance/sdk)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Official PHP SDK for the Klink platform. This SDK provides a simple and consistent interface for both Publishers and Advertisers to integrate with Klink's API.

## Features

* 🚀 Easy to use - Simple initialization and intuitive API
* 🔐 Built-in authentication - Automatic request signing and auth headers
* 📝 Full PHP 8+ support - Modern PHP with type declarations
* 🐛 Debug mode - Detailed logging for troubleshooting
* ⚡ Lightweight - Minimal dependencies (only Guzzle HTTP client)

## Installation

```bash
composer require klinkfinance/sdk
```

## Requirements

* PHP >= 8.0
* ext-json
* guzzlehttp/guzzle ^7.0

## Quick Start

### Basic Usage (Publisher)

```php
<?php

require 'vendor/autoload.php';

use KlinkFinance\SDK\KlinkSDK;

// Initialize SDK using factory method - performs health check before initialization
// SDK will only be created if health check returns status 200
$client = KlinkSDK::create([
    'apiKey' => 'your-api-key',
    'apiSecret' => 'your-api-secret', // Required for Publisher
]);

// Use the publisher client
$publisher = $client->publisher();

// Fetch offers
$response = $publisher->getOffers([
    'page' => 1,
    'limit' => 50,
    'category' => ['gaming', 'finance'],
    'country' => 'US',
    'device_name' => 'android',
]);

echo "Fetched " . count($response['data']) . " offers\n";
```

### Basic Usage (Advertiser)

```php
<?php

require 'vendor/autoload.php';

use KlinkFinance\SDK\KlinkSDK;

// Initialize SDK - apiSecret is optional for Advertiser
$client = KlinkSDK::create([
    'apiKey' => 'your-api-key',
    // 'apiSecret' => 'your-api-secret', // Optional for Advertiser
]);

// Use the advertiser client
$advertiser = $client->advertiser();

// Send postback
$advertiser->sendPostback([
    'event_name' => 'create_account',
    'offer_id' => 'offer_123',
    'sub1' => 'sub1_value',
    'tx_id' => 'tx_123',
    'isChargeback' => false,
    'chargebackReason' => '',
    'isTest' => true,
]);
```

## Configuration Options

```php
$client = KlinkSDK::create([
    // Required: API key for authentication
    'apiKey' => 'your-api-key',
    
    // Required for Publisher, optional for Advertiser
    'apiSecret' => 'your-api-secret',
    
    // Optional: Base URL for the Klink API
    'baseUrl' => 'https://klink-quest.klink.finance/api',
    
    // Optional: Request timeout in milliseconds
    'timeoutMs' => 8000,
    
    // Optional: Enable debug logging
    'debug' => true,
]);
```

## Publisher API Methods

### Get Offers

```php
$offers = $publisher->getOffers([
    'page' => 1,
    'limit' => 100,
    'category' => ['gaming', 'finance'],
    'country' => ['US', 'GB'],
    'device_name' => 'mobile',
    'platform' => 'iOS',
    'reload' => false,
    'sort_by' => 'payout',
]);
```

### Get Conversions

```php
$conversions = $publisher->getConversions([
    'page' => 1,
    'limit' => 20,
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31',
    'status' => 'approved',
    'offer_id' => 'offer_123',
    'sort_by' => 'completedAt',
    'sort_order' => 'desc',
]);
```

### Get Users

```php
$users = $publisher->getUsers([
    'page' => 1,
    'limit' => 20,
    'status' => 'active',
    'search' => 'john',
]);
```

### Get Postbacks

```php
$postbacks = $publisher->getPostbacks([
    'page' => 1,
    'limit' => 20,
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31',
    'status' => 200,
    'name' => 'conversion_postback',
    'sort_by' => 'created_at',
    'sort_order' => 'desc',
]);
```

### Get Countries

```php
$countries = $publisher->getCountries();
// or with reload
$countries = $publisher->getCountries(true);
```

### Get Categories

```php
$categories = $publisher->getCategories();
// or with reload
$categories = $publisher->getCategories(true);
```

### Health Check

```php
$health = $publisher->healthCheck();
```

### Send Test Postback

```php
$response = $publisher->sendTestPostback([
    'params' => [
        'offerName' => 'conversion',
        'offerId' => '{{offerId}}',
        'userId' => '{{userId}}',
        'conversionId' => '{{conversionId}}',
        'payout' => '{{payout}}',
        'status' => '{{status}}',
    ],
]);
```

## Advertiser API Methods

### Health Check

```php
$health = $advertiser->healthCheck();
```

### Send Postback

```php
$response = $advertiser->sendPostback([
    'event_name' => 'create_account',
    'offer_id' => 'offer_123',
    'sub1' => 'sub1_value',
    'tx_id' => 'transaction_id_123',
    'isChargeback' => false,
    'chargebackReason' => '',
    'isTest' => true,
]);
```

## Error Handling

```php
use KlinkFinance\SDK\KlinkSDK;
use KlinkFinance\SDK\Types\KlinkConfigException;
use KlinkFinance\SDK\Types\KlinkAuthException;
use KlinkFinance\SDK\Types\KlinkAPIException;
use KlinkFinance\SDK\Types\KlinkNetworkException;

try {
    $client = KlinkSDK::create([
        'apiKey' => 'invalid-key',
        'apiSecret' => 'invalid-secret',
    ]);
    
    // Make API calls...
} catch (KlinkConfigException $e) {
    echo "Configuration error: " . $e->getMessage() . "\n";
} catch (KlinkAuthException $e) {
    echo "Authentication failed: " . $e->getMessage() . "\n";
} catch (KlinkAPIException $e) {
    echo "API error: " . $e->getMessage() . " (Status: " . $e->getStatusCode() . ")\n";
} catch (KlinkNetworkException $e) {
    echo "Network error: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "Unexpected error: " . $e->getMessage() . "\n";
}
```

## License

MIT

## Support

For issues, questions, or contributions, please contact the Klink team.
