# Contributing to Klink Finance SDKs

Thank you for your interest in contributing to the Klink Finance SDKs! This monorepo contains both the PHP and Python SDKs.

## Development Setup

This project uses a `Makefile` to simplify development tasks.

### Prerequisites

- PHP 8.0 or higher
- Composer
- Python 3.8 or higher
- pip

### Initial Setup

Clone the repository and install dependencies for both SDKs:

```bash
make install
```

This command runs `composer install` for the PHP SDK and `pip install -e .` for the Python SDK.

## Project Structure

```
klink-sdks/
├── php-sdk/           # PHP SDK implementation
├── python-sdk/        # Python SDK implementation
├── Makefile           # Unified management commands
└── ...
```

## Running Tests

To run tests for both SDKs:

```bash
make test
```

Or run them individually:

```bash
make test-php
make test-python
```

## Code Style

### PHP

We follow PSR-12 coding standards. Please ensure your code complies before submitting a PR.

```bash
make lint-php
```

### Python

We follow PEP 8 coding standards.

```bash
make lint-python
```

## Pull Request Process

1.  Fork the repository and create your branch from `main`.
2.  If you've added code that should be tested, add tests.
3.  Ensure the test suite passes (`make test`).
4.  Make sure your code lints (`make lint`).
5.  Update the documentation if necessary.
6.  Issue that pull request!

## Reporting Issues

If you find a bug or have a feature request, please open an issue in the repository. Be sure to specify which SDK (PHP, Python, or both) the issue relates to.

## License

By contributing, you agree that your contributions will be licensed under the project's license.
