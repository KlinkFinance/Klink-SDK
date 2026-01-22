# SDK Comparison & Migration Guide

This document provides a side-by-side comparison of the Node.js, PHP, and Python SDKs for Klink Finance, along with migration examples.

## Quick Comparison

| Feature | Node.js | PHP | Python |
|---------|---------|-----|--------|
| **Language Version** | Node.js >= 16.0.0 | PHP >= 8.0 | Python >= 3.8 |
| **Package Manager** | npm/yarn/pnpm | Composer | pip |
| **HTTP Client** | Built-in fetch | Guzzle 7.0 | requests 2.25+ |
| **Type System** | TypeScript | PHP 8 type hints + PHPDoc | Python type hints |
| **Module System** | CommonJS + ESM | PSR-4 Autoloading | Python packages |
| **Error Handling** | Custom Error classes | Custom Exception classes | Custom Exception classes |
| **Async Support** | Native async/await | Synchronous | Synchronous |
| **Debug Mode** | ✅ Yes | ✅ Yes | ✅ Yes |
| **Health Check** | ✅ Factory method | ✅ Factory method | ✅ Factory method |

## Installation Comparison

### Node.js
```bash
npm install @klinkfinance/sdk
# or
yarn add @klinkfinance/sdk
# or
pnpm add @klinkfinance/sdk
```

### PHP
```bash
composer require klinkfinance/sdk
```

### Python
```bash
pip install klinkfinance-sdk
```

## Initialization Comparison

### Node.js
```javascript
import { KlinkSDK } from "@klinkfinance/sdk";

const client = await KlinkSDK.create({
  apiKey: process.env.KLINK_API_KEY,
  apiSecret: process.env.KLINK_API_SECRET,
  debug: true
});
```

### PHP
```php
use KlinkFinance\SDK\KlinkSDK;

$client = KlinkSDK::create([
    'apiKey' => $_ENV['KLINK_API_KEY'],
    'apiSecret' => $_ENV['KLINK_API_SECRET'],
    'debug' => true
]);
```

### Python
```python
from klink_sdk import KlinkSDK

client = KlinkSDK.create(
    api_key=os.environ["KLINK_API_KEY"],
    api_secret=os.environ["KLINK_API_SECRET"],
    debug=True
)
```

## Publisher API Comparison

### Fetching Offers

#### Node.js
```javascript
const offers = await publisher.getOffers({
  page: 1,
  limit: 50,
  category: ["gaming", "finance"],
  country: ["US", "GB"]
});
```

#### PHP
```php
$offers = $publisher->getOffers([
    'page' => 1,
    'limit' => 50,
    'category' => ['gaming', 'finance'],
    'country' => ['US', 'GB']
]);
```

#### Python
```python
offers = publisher.get_offers(
    page=1,
    limit=50,
    category=["gaming", "finance"],
    country=["US", "GB"]
)
```

### Fetching Conversions

#### Node.js
```javascript
const conversions = await publisher.getConversions({
  page: 1,
  limit: 20,
  startDate: "2024-01-01",
  endDate: "2024-12-31",
  status: "approved"
});
```

#### PHP
```php
$conversions = $publisher->getConversions([
    'page' => 1,
    'limit' => 20,
    'start_date' => '2024-01-01',
    'end_date' => '2024-12-31',
    'status' => 'approved'
]);
```

#### Python
```python
conversions = publisher.get_conversions(
    page=1,
    limit=20,
    start_date="2024-01-01",
    end_date="2024-12-31",
    status="approved"
)
```

## Advertiser API Comparison

### Sending Postback

#### Node.js
```javascript
await advertiser.sendPostback({
  event_name: "create_account",
  offer_id: "offer_123",
  sub1: "sub1_value",
  tx_id: "tx_123",
  isChargeback: false,
  chargebackReason: "",
  isTest: true
});
```

#### PHP
```php
$advertiser->sendPostback([
    'event_name' => 'create_account',
    'offer_id' => 'offer_123',
    'sub1' => 'sub1_value',
    'tx_id' => 'tx_123',
    'isChargeback' => false,
    'chargebackReason' => '',
    'isTest' => true
]);
```

#### Python
```python
advertiser.send_postback(
    event_name="create_account",
    offer_id="offer_123",
    sub1="sub1_value",
    tx_id="tx_123",
    is_chargeback=False,
    chargeback_reason="",
    is_test=True
)
```

## Error Handling Comparison

### Node.js
```javascript
try {
  const client = await KlinkSDK.create({
    apiKey: "invalid",
    apiSecret: "invalid"
  });
} catch (error) {
  if (error instanceof KlinkConfigError) {
    console.error("Config error:", error.message);
  } else if (error instanceof KlinkAuthError) {
    console.error("Auth error:", error.message);
  } else if (error instanceof KlinkAPIError) {
    console.error("API error:", error.message, error.statusCode);
  }
}
```

### PHP
```php
use KlinkFinance\SDK\Exceptions\*;

try {
    $client = KlinkSDK::create([
        'apiKey' => 'invalid',
        'apiSecret' => 'invalid'
    ]);
} catch (KlinkConfigException $e) {
    echo "Config error: " . $e->getMessage();
} catch (KlinkAuthException $e) {
    echo "Auth error: " . $e->getMessage();
} catch (KlinkAPIException $e) {
    echo "API error: " . $e->getMessage();
    echo "Status: " . $e->getStatusCode();
}
```

### Python
```python
from klink_sdk import (
    KlinkConfigException,
    KlinkAuthException,
    KlinkAPIException
)

try:
    client = KlinkSDK.create(
        api_key="invalid",
        api_secret="invalid"
    )
except KlinkConfigException as e:
    print(f"Config error: {e}")
except KlinkAuthException as e:
    print(f"Auth error: {e} (Status: {e.status_code})")
except KlinkAPIException as e:
    print(f"API error: {e} (Status: {e.status_code})")
```

## Naming Conventions

### Parameters

| Node.js (camelCase) | PHP (snake_case) | Python (snake_case) |
|---------------------|------------------|---------------------|
| `apiKey` | `apiKey` | `api_key` |
| `apiSecret` | `apiSecret` | `api_secret` |
| `baseUrl` | `baseUrl` | `base_url` |
| `timeoutMs` | `timeoutMs` | `timeout_ms` |
| `startDate` | `start_date` | `start_date` |
| `endDate` | `end_date` | `end_date` |
| `deviceName` | `device_name` | `device_name` |
| `offerId` | `offer_id` | `offer_id` |
| `isChargeback` | `isChargeback` | `is_chargeback` |
| `chargebackReason` | `chargebackReason` | `chargeback_reason` |
| `isTest` | `isTest` | `is_test` |

### Methods

| Node.js (camelCase) | PHP (camelCase) | Python (snake_case) |
|---------------------|-----------------|---------------------|
| `getOffers()` | `getOffers()` | `get_offers()` |
| `getConversions()` | `getConversions()` | `get_conversions()` |
| `getUsers()` | `getUsers()` | `get_users()` |
| `getPostbacks()` | `getPostbacks()` | `get_postbacks()` |
| `getCountries()` | `getCountries()` | `get_countries()` |
| `getCategories()` | `getCategories()` | `get_categories()` |
| `sendPostback()` | `sendPostback()` | `send_postback()` |
| `healthCheck()` | `healthCheck()` | `health_check()` |

## Key Differences

### 1. Async vs Sync

**Node.js**: All API methods are async and return Promises
```javascript
const offers = await publisher.getOffers();
```

**PHP & Python**: All API methods are synchronous
```php
// PHP
$offers = $publisher->getOffers();
```
```python
# Python
offers = publisher.get_offers()
```

### 2. Array/List Handling

All three SDKs automatically convert arrays to comma-separated strings for API parameters:

```javascript
// Node.js
category: ["gaming", "finance"] → "gaming,finance"
```

```php
// PHP
'category' => ['gaming', 'finance'] → "gaming,finance"
```

```python
# Python
category=["gaming", "finance"] → "gaming,finance"
```

### 3. Property Access

**Node.js & Python**: Use properties
```javascript
// Node.js
const publisher = client.publisher;
const config = client.config;
```
```python
# Python
publisher = client.publisher
config = client.config
```

**PHP**: Use methods
```php
// PHP
$publisher = $client->publisher();
$config = $client->getConfig();
```

### 4. Exception/Error Naming

**Node.js**: Uses `Error` suffix
- `KlinkConfigError`
- `KlinkAuthError`
- `KlinkAPIError`
- `KlinkNetworkError`

**PHP & Python**: Use `Exception` suffix
- `KlinkConfigException`
- `KlinkAuthException`
- `KlinkAPIException`
- `KlinkNetworkException`

## Migration Tips

### From Node.js to PHP
1. Change method calls from `await` to synchronous
2. Keep parameter names (mostly same, using camelCase/snake_case mix in both)
3. Change `client.publisher` to `$client->publisher()`
4. Import exception classes instead of error classes

### From Node.js to Python
1. Change camelCase to snake_case for parameters and methods
2. Remove `await` keywords
3. Change `Error` suffix to `Exception`
4. Use `client.publisher` (property access is the same)

### From PHP to Python
1. Keep synchronous approach
2. Change method names from camelCase to snake_case
3. Change parameter names from camelCase to snake_case
4. Use property access instead of method calls for clients

## Common Patterns

### Environment Variables

All three SDKs support environment variables for configuration:

```javascript
// Node.js
process.env.KLINK_API_KEY
```

```php
// PHP
$_ENV['KLINK_API_KEY']
```

```python
# Python
os.environ["KLINK_API_KEY"]
```

### Debug Mode

All SDKs support debug mode for logging:

```javascript
// Node.js
{ debug: true }
```

```php
// PHP
['debug' => true]
```

```python
# Python
debug=True
```

### Health Checks

All SDKs perform health checks before initialization:

```javascript
// Node.js
const client = await KlinkSDK.create({...});
```

```php
// PHP
$client = KlinkSDK::create([...]);
```

```python
# Python
client = KlinkSDK.create(...)
```

## Best Practices

1. **Always use factory method**: Use `create()` instead of direct instantiation
2. **Use environment variables**: Never hardcode API keys
3. **Handle errors properly**: Use try-catch blocks with specific exception types
4. **Enable debug mode** during development
5. **Use type hints**: Leverage IDE autocomplete with TypeScript/PHP/Python types
6. **Follow naming conventions**: Stick to each language's conventions
