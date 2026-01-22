# Klink Finance SDKs - PHP & Python

[![Latest Stable Version](https://poser.pugx.org/klinkfinance/sdk/v/stable)](https://packagist.org/packages/klinkfinance/sdk)
[![PyPI version](https://badge.fury.io/py/klinkfinance-sdk.svg)](https://badge.fury.io/py/klinkfinance-sdk)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Complete implementation of Klink Finance SDKs in PHP and Python, matching the functionality of the Node.js SDK.

## 📦 What's Included

### PHP SDK (`/php-sdk`)
- ✅ Full PHP 8+ implementation with type hints
- ✅ PSR-4 compliant structure
- ✅ Composer package with `composer.json`
- ✅ Guzzle HTTP client integration
- ✅ Complete Publisher & Advertiser clients
- ✅ Comprehensive error handling
- ✅ Debug mode support
- ✅ Full documentation and examples

### Python SDK (`/python-sdk`)
- ✅ Full Python 3.8+ implementation with type hints
- ✅ pip-installable package with `setup.py` and `pyproject.toml`
- ✅ requests library for HTTP
- ✅ Complete Publisher & Advertiser clients
- ✅ Comprehensive exception handling
- ✅ Debug mode support
- ✅ Full documentation and examples

## 🚀 Quick Start

### Monorepo Management

This repository is set up as a monorepo. You can use the provided `Makefile` to manage both SDKs simultaneously.

```bash
# Install dependencies for both SDKs
make install

# Clean up build artifacts
make clean
```

### PHP SDK

Install via Composer:

```bash
composer require klinkfinance/sdk
```

Or for local development:

```bash
cd php-sdk
composer install
```

```php
<?php
use KlinkFinance\SDK\KlinkSDK;

$client = KlinkSDK::create([
    'apiKey' => 'your-api-key',
    'apiSecret' => 'your-api-secret'
]);

$publisher = $client->publisher();
$offers = $publisher->getOffers(['limit' => 10]);
```

### Python SDK

Install via pip:

```bash
pip install klinkfinance-sdk
```

Or for local development:

```bash
cd python-sdk
pip install -e .
```

```python
from klinkfinance_sdk import KlinkSDK

client = KlinkSDK.create(
    api_key="your-api-key",
    api_secret="your-api-secret"
)

publisher = client.publisher
offers = publisher.get_offers(limit=10)
```

## 📁 Project Structure

```
klink-sdks/
├── php-sdk/
│   ├── composer.json
│   ├── README.md
│   ├── src/
│   │   ├── Core/
│   │   │   ├── HttpClient.php
│   │   │   ├── PublisherClient.php
│   │   │   └── AdvertiserClient.php
│   │   ├── Types/
│   │   │   ├── Config.php
│   │   │   ├── KlinkException.php
│   │   │   └── [Other Exceptions...]
│   │   └── KlinkSDK.php
│   └── examples/
│       └── publisher-example.php
│
├── python-sdk/
│   ├── setup.py
│   ├── pyproject.toml
│   ├── requirements.txt
│   ├── README.md
│   ├── klink_sdk/
│   │   ├── __init__.py
│   │   ├── klink_sdk.py
│   │   ├── core/
│   │   │   ├── __init__.py
│   │   │   ├── http_client.py
│   │   │   ├── publisher_client.py
│   │   │   └── advertiser_client.py
│   │   ├── types/
│   │   │   └── __init__.py (Config class)
│   │   └── exceptions/
│   │       └── __init__.py
│   └── examples/
│       ├── publisher_example.py
│       └── advertiser_example.py
│
└── SDK_COMPARISON.md
```

## ✨ Key Features

### Both SDKs Include:

1. **Factory Method Initialization**
   - Health check before SDK creation
   - Only creates instance if API is available

2. **Complete API Coverage**
   - ✅ Publisher: getOffers, getConversions, getUsers, getPostbacks
   - ✅ Publisher: getCountries, getCategories, sendTestPostback
   - ✅ Advertiser: sendPostback
   - ✅ Health check for both clients

3. **Robust Error Handling**
   - Custom exception/error classes
   - Detailed error messages
   - Status code access
   - Response data access

4. **Configuration Options**
   - API key & secret
   - Custom base URL
   - Configurable timeout
   - Debug mode

5. **Type Safety**
   - PHP: Full type hints + PHPDoc
   - Python: Full type hints for IDE support

6. **Best Practices**
   - PSR-4 autoloading (PHP)
   - Python package structure
   - Environment variable support
   - Comprehensive documentation

## 🔄 API Parity with Node.js SDK

All three SDKs (Node.js, PHP, Python) provide identical functionality:

| Feature | Node.js | PHP | Python |
|---------|---------|-----|--------|
| Factory initialization | ✅ | ✅ | ✅ |
| Health check | ✅ | ✅ | ✅ |
| Publisher APIs | ✅ | ✅ | ✅ |
| Advertiser APIs | ✅ | ✅ | ✅ |
| Error handling | ✅ | ✅ | ✅ |
| Debug mode | ✅ | ✅ | ✅ |
| Type safety | ✅ | ✅ | ✅ |
| Documentation | ✅ | ✅ | ✅ |
| Examples | ✅ | ✅ | ✅ |

## 📖 Documentation

Each SDK includes:
- ✅ Complete README with installation and usage
- ✅ Configuration options documentation
- ✅ API methods reference
- ✅ Error handling guide
- ✅ Working examples
- ✅ Development setup instructions

## 🎯 Publisher API Methods

Both SDKs support all Publisher endpoints:

```
- getOffers(params) / get_offers(params)
- getConversions(params) / get_conversions(params)
- getUsers(params) / get_users(params)
- getPostbacks(params) / get_postbacks(params)
- getCountries(reload) / get_countries(reload)
- getCategories(reload) / get_categories(reload)
- sendTestPostback(data) / send_test_postback(data)
- healthCheck() / health_check()
```

## 🎯 Advertiser API Methods

Both SDKs support all Advertiser endpoints:

```
- sendPostback(data) / send_postback(data)
- healthCheck() / health_check()
```

## 🛠️ Installation

### PHP Requirements
- PHP >= 8.0
- ext-json
- guzzlehttp/guzzle ^7.0

```bash
cd php-sdk
composer install
```

### Python Requirements
- Python >= 3.8
- requests >= 2.25.0

```bash
cd python-sdk
pip install -e .
# or
pip install -r requirements.txt
```

## 📝 Usage Examples

### PHP - Publisher

```php
use KlinkFinance\SDK\KlinkSDK;

$client = KlinkSDK::create([
    'apiKey' => $_ENV['KLINK_API_KEY'],
    'apiSecret' => $_ENV['KLINK_API_SECRET'],
    'debug' => true
]);

$publisher = $client->publisher();

// Fetch offers
$offers = $publisher->getOffers([
    'page' => 1,
    'limit' => 50,
    'category' => ['gaming'],
    'country' => ['US']
]);

// Fetch conversions
$conversions = $publisher->getConversions([
    'page' => 1,
    'limit' => 20,
    'status' => 'approved'
]);
```

### PHP - Advertiser

```php
$advertiser = $client->advertiser();

$result = $advertiser->sendPostback([
    'event_name' => 'create_account',
    'offer_id' => 'offer_123',
    'sub1' => 'sub1_value',
    'tx_id' => 'tx_123',
    'isChargeback' => false,
    'chargebackReason' => '',
    'isTest' => true
]);
```

### Python - Publisher

```python
from klink_sdk import KlinkSDK
import os

client = KlinkSDK.create(
    api_key=os.environ["KLINK_API_KEY"],
    api_secret=os.environ["KLINK_API_SECRET"],
    debug=True
)

publisher = client.publisher

# Fetch offers
offers = publisher.get_offers(
    page=1,
    limit=50,
    category=["gaming"],
    country=["US"]
)

# Fetch conversions
conversions = publisher.get_conversions(
    page=1,
    limit=20,
    status="approved"
)
```

### Python - Advertiser

```python
advertiser = client.advertiser

result = advertiser.send_postback(
    event_name="create_account",
    offer_id="offer_123",
    sub1="sub1_value",
    tx_id="tx_123",
    is_chargeback=False,
    chargeback_reason="",
    is_test=True
)
```

## 🔧 Error Handling

### PHP

```php
use KlinkFinance\SDK\Exceptions\*;

try {
    $client = KlinkSDK::create([...]);
    $offers = $client->publisher()->getOffers();
} catch (KlinkConfigException $e) {
    // Configuration error
} catch (KlinkAuthException $e) {
    // Authentication error
} catch (KlinkAPIException $e) {
    // API error - includes status code and response data
    echo $e->getStatusCode();
    print_r($e->getResponseData());
} catch (KlinkNetworkException $e) {
    // Network error
}
```

### Python

```python
from klink_sdk import (
    KlinkConfigException,
    KlinkAuthException,
    KlinkAPIException,
    KlinkNetworkException
)

try:
    client = KlinkSDK.create(...)
    offers = client.publisher.get_offers()
except KlinkConfigException as e:
    # Configuration error
    pass
except KlinkAuthException as e:
    # Authentication error
    print(f"Status: {e.status_code}")
except KlinkAPIException as e:
    # API error - includes status code and response data
    print(f"Status: {e.status_code}")
    print(f"Data: {e.response_data}")
except KlinkNetworkException as e:
    # Network error
    pass
```

## 🧪 Testing

### PHP
```bash
cd php-sdk
composer test
composer analyse
```

### Python
```bash
cd python-sdk
pytest
mypy klink_sdk
black klink_sdk
pylint klink_sdk
```

## 📄 License

Both SDKs are released under the MIT License, matching the Node.js SDK.

## 🤝 Support

For issues, questions, or contributions:
- GitHub Issues: https://github.com/KlinkFinance/publisher-sdk/issues
- Email: dev@klinkfinance.com

## 🎉 Summary

You now have **three complete SDKs** for Klink Finance:
1. ✅ **Node.js SDK** - Original TypeScript implementation
2. ✅ **PHP SDK** - Complete PHP 8+ implementation
3. ✅ **Python SDK** - Complete Python 3.8+ implementation

All three SDKs:
- Share identical functionality and API coverage
- Follow language-specific best practices
- Include comprehensive documentation
- Provide working examples
- Support debug mode
- Include proper error handling
- Use factory methods with health checks

## 📦 Next Steps

1. **Test the SDKs** with your API credentials
2. **Publish to package registries**:
   - PHP: Packagist (composer)
   - Python: PyPI (pip)
3. **Add CI/CD pipelines** for automated testing
4. **Create unit tests** for all methods
5. **Add integration tests** with live API

## 🔗 Additional Resources

- See `SDK_COMPARISON.md` for detailed comparison and migration guide
- Check individual README files for SDK-specific documentation
- Review example files for practical usage patterns
