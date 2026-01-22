# Klink Finance SDK - Multi-Language Implementation

This document provides an overview of the PHP and Python SDKs created based on the Node.js SDK.

## Overview

Both SDKs maintain feature parity with the Node.js SDK and follow the same architecture:

### Core Features
✅ Factory pattern initialization with health check (`create()` method)
✅ Publisher and Advertiser client separation
✅ Bearer token + API secret authentication
✅ Comprehensive error handling with custom exceptions
✅ Debug logging support
✅ Type safety (PHP 8+ type declarations, Python type hints)
✅ Modern HTTP client implementation
✅ Full API endpoint coverage

## SDK Comparison

| Feature | Node.js | PHP | Python |
|---------|---------|-----|--------|
| Min Version | 16.0.0 | 8.0 | 3.8 |
| HTTP Client | fetch API | Guzzle 7.0 | requests |
| Type System | TypeScript | PHP 8+ types | Type hints |
| Package Manager | npm | Composer | pip |
| Health Check | ✅ | ✅ | ✅ |
| Error Classes | ✅ | ✅ | ✅ |
| Debug Logging | ✅ | ✅ | ✅ |

## Installation

### PHP
```bash
composer require klinkfinance/sdk
```

### Python
```bash
pip install klinkfinance-sdk
```

## Quick Start Comparison

### Node.js
```javascript
import { KlinkSDK } from "@klinkfinance/sdk";

const client = await KlinkSDK.create({
  apiKey: "your-key",
  apiSecret: "your-secret"
});

const publisher = client.publisher;
const offers = await publisher.getOffers();
```

### PHP
```php
use KlinkFinance\SDK\KlinkSDK;

$client = KlinkSDK::create([
    'apiKey' => 'your-key',
    'apiSecret' => 'your-secret'
]);

$publisher = $client->publisher();
$offers = $publisher->getOffers();
```

### Python
```python
from klinkfinance_sdk import KlinkSDK

client = KlinkSDK.create({
    "api_key": "your-key",
    "api_secret": "your-secret"
})

publisher = client.publisher()
offers = publisher.get_offers()
```

## API Method Mapping

### Publisher Methods

| Node.js | PHP | Python |
|---------|-----|--------|
| `getOffers()` | `getOffers()` | `get_offers()` |
| `getConversions()` | `getConversions()` | `get_conversions()` |
| `getUsers()` | `getUsers()` | `get_users()` |
| `getPostbacks()` | `getPostbacks()` | `get_postbacks()` |
| `getCountries()` | `getCountries()` | `get_countries()` |
| `getCategories()` | `getCategories()` | `get_categories()` |
| `healthCheck()` | `healthCheck()` | `health_check()` |
| `sendTestPostback()` | `sendTestPostback()` | `send_test_postback()` |

### Advertiser Methods

| Node.js | PHP | Python |
|---------|-----|--------|
| `healthCheck()` | `healthCheck()` | `health_check()` |
| `sendPostback()` | `sendPostback()` | `send_postback()` |

## Error Handling Comparison

### Node.js
```javascript
try {
  const client = await KlinkSDK.create({...});
} catch (error) {
  if (error instanceof KlinkConfigError) {
    // Handle config error
  } else if (error instanceof KlinkAuthError) {
    // Handle auth error
  }
}
```

### PHP
```php
try {
    $client = KlinkSDK::create([...]);
} catch (KlinkConfigException $e) {
    // Handle config error
} catch (KlinkAuthException $e) {
    // Handle auth error
}
```

### Python
```python
try:
    client = KlinkSDK.create({...})
except KlinkConfigException as e:
    # Handle config error
except KlinkAuthException as e:
    # Handle auth error
```

## Architecture

All three SDKs follow the same architectural pattern:

```
├── Core/
│   ├── HttpClient        # HTTP communication
│   ├── PublisherClient   # Publisher API methods
│   └── AdvertiserClient  # Advertiser API methods
├── Types/
│   ├── Config           # Configuration class
│   └── Exceptions       # Custom error classes
├── Utils/
│   ├── Logger          # Debug logging
│   └── Validator       # Config validation
└── KlinkSDK            # Main SDK class
```

## Key Implementation Details

### 1. Factory Pattern with Health Check
All SDKs use the `create()` factory method that:
- Validates configuration
- Performs health check before initialization
- Only creates SDK instance if health check passes
- Returns properly initialized SDK instance

### 2. Client Separation
- Publisher client requires `apiSecret`
- Advertiser client works with just `apiKey`
- Backend validates `user_type` based on credentials

### 3. Error Handling
Four custom exception types:
- `ConfigException` - Configuration validation errors
- `AuthException` - Authentication/authorization errors
- `APIException` - API errors with status codes
- `NetworkException` - Network/connectivity errors

### 4. Request Authentication
- `Authorization: Bearer {apiKey}` header
- `X-API-Secret: {apiSecret}` header (when provided)

## Testing

### PHP
```bash
cd php-sdk
composer install
php examples/publisher_example.php
```

### Python
```bash
cd python-sdk
pip install -e .
python examples/publisher_example.py
```

## Environment Variables

All SDKs support environment variables for configuration:

```bash
# Publisher (requires API secret)
export KLINK_API_KEY="your-api-key"
export KLINK_API_SECRET="your-api-secret"

# Advertiser (API secret optional)
export KLINK_API_KEY="your-api-key"
```

## Documentation

Each SDK includes:
- Comprehensive README.md
- Working examples for Publisher and Advertiser
- Inline code documentation (PHPDoc, Docstrings)
- Type definitions

## Next Steps

### PHP SDK
1. Publish to Packagist
2. Add PHPUnit tests
3. Set up CI/CD pipeline
4. Add PHPStan static analysis

### Python SDK
1. Publish to PyPI
2. Add pytest tests
3. Set up CI/CD pipeline
4. Add mypy type checking

## License

All SDKs are released under the MIT License.
