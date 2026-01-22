# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2024-01-22

### Added
- **Monorepo**: Unified project structure with a root `Makefile` for consistent build, test, and lint commands.
- **CI/CD**: GitHub Actions workflows for automated testing and publishing to PyPI/Packagist.
- **Documentation**: Added `PUBLISHING.md` guide and updated project structure docs.

### Fixed
- **PHP SDK**:
  - Fixed PSR-4 autoloading compliance by splitting `Exceptions.php` into individual files.
  - Resolved PHPStan static analysis errors (unused `apiSecret`, `create()` return type).
  - Fixed `make test-php` to gracefully handle missing PHP environments.
- **Python SDK**:
  - Fixed `pytest` failures by adding `pytest-mock` dependency.
  - Resolved PEP 668 "externally managed environment" errors by adding virtual env support to Makefile.
  - Synced version numbers between `setup.py` and `pyproject.toml`.

## [1.0.0] - 2023-10-27

### Initial Release
- Complete implementation of Klink Finance SDKs for PHP and Python.
- Feature parity with Node.js SDK.
- Publisher and Advertiser clients.
- Health check and authentication support.
