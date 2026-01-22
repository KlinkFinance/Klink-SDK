# Klink Finance SDK - Quick Start Guide

## What's Included

✅ **PHP SDK** - Complete implementation with Composer support
✅ **Python SDK** - Complete implementation with pip support
✅ **Full documentation** - Comprehensive READMEs and guides
✅ **Working examples** - Publisher and Advertiser examples for both
✅ **Implementation guide** - Complete feature comparison

## Package Structure

```
klink-sdks/
├── php-sdk/           # PHP 8+ SDK with Guzzle
├── python-sdk/        # Python 3.8+ SDK with requests
├── STRUCTURE.md       # Complete directory structure
└── SDK_IMPLEMENTATION_GUIDE.md  # Implementation details
```

## Installation

### Monorepo (Recommended)
You can install dependencies for both SDKs using the provided Makefile:

```bash
make install
```

### PHP Only
```bash
cd php-sdk
composer install
```

### Python Only
```bash
cd python-sdk
pip install -e .
```

## Usage Examples

### PHP - Publisher
```php
<?php
require 'vendor/autoload.php';
use KlinkFinance\SDK\KlinkSDK;

$client = KlinkSDK::create([
    'apiKey' => getenv('KLINK_API_KEY'),
    'apiSecret' => getenv('KLINK_API_SECRET'),
    'debug' => true,
]);

$publisher = $client->publisher();
$offers = $publisher->getOffers(['limit' => 10]);
echo "Found " . count($offers['data']) . " offers\n";
```

### Python - Publisher
```python
import os
from klinkfinance_sdk import KlinkSDK

client = KlinkSDK.create({
    "api_key": os.getenv("KLINK_API_KEY"),
    "api_secret": os.getenv("KLINK_API_SECRET"),
    "debug": True,
})

publisher = client.publisher()
offers = publisher.get_offers({"limit": 10})
print(f"Found {len(offers['data'])} offers")
```

## Testing

### PHP
```bash
cd php-sdk
export KLINK_API_KEY="your-key"
export KLINK_API_SECRET="your-secret"
php examples/publisher_example.php
```

### Python
```bash
cd python-sdk
export KLINK_API_KEY="your-key"
export KLINK_API_SECRET="your-secret"
python examples/publisher_example.py
```

## Key Features

### Both SDKs Include:
1. **Health check initialization** - Validates API connection before creating SDK
2. **Publisher & Advertiser clients** - Separated concerns for different API types
3. **Complete API coverage** - All endpoints from Node.js SDK
4. **Error handling** - 4 custom exception types
5. **Debug logging** - Detailed request/response logging
6. **Type safety** - PHP 8+ types, Python type hints

### API Methods

**Publisher:**
- getOffers/get_offers
- getConversions/get_conversions
- getUsers/get_users
- getPostbacks/get_postbacks
- getCountries/get_countries
- getCategories/get_categories
- healthCheck/health_check
- sendTestPostback/send_test_postback

**Advertiser:**
- healthCheck/health_check
- sendPostback/send_postback

## File Overview

### PHP SDK Files (13 total)
- `src/KlinkSDK.php` - Main SDK class
- `src/Core/` - HTTP client, Publisher/Advertiser clients
- `src/Types/` - Config, Exceptions
- `src/Utils/` - Logger, Validator
- `examples/` - Working examples
- `composer.json` - Package config

### Python SDK Files (17 total)
- `klinkfinance_sdk/sdk.py` - Main SDK class
- `klinkfinance_sdk/core/` - HTTP client, Publisher/Advertiser clients
- `klinkfinance_sdk/types/` - Config, Exceptions
- `klinkfinance_sdk/utils/` - Logger, Validator
- `examples/` - Working examples
- `setup.py` - Package config

## Next Steps

1. **Set environment variables** for your API credentials
2. **Run examples** to verify functionality
3. **Customize configuration** (base URL, timeout, debug mode)
4. **Add tests** using PHPUnit or pytest
5. **Publish packages** to Packagist and PyPI

## Documentation

- `php-sdk/README.md` - PHP-specific documentation
- `python-sdk/README.md` - Python-specific documentation
- `SDK_IMPLEMENTATION_GUIDE.md` - Cross-SDK comparison
- `STRUCTURE.md` - Complete directory structure

## Support

For questions or issues, contact the Klink Finance team.
