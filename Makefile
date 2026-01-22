.PHONY: help install test clean lint

help:
	@echo "Klink SDK Monorepo Commands"
	@echo "==========================="
	@echo "make install    - Install dependencies for both SDKs"
	@echo "make test       - Run tests for both SDKs"
	@echo "make lint       - Run linters for both SDKs"
	@echo "make clean      - Clean up build artifacts"

install: install-php install-python

install-php:
	@echo "Installing PHP dependencies..."
	@if command -v composer >/dev/null 2>&1; then \
		composer install; \
	else \
		echo "Composer not found, skipping PHP installation."; \
	fi

# Python Virtual Environment
VENV := python-sdk/venv
PYTHON := $(VENV)/bin/python
PIP := $(VENV)/bin/pip

install-python:
	@echo "Installing Python dependencies..."
	python3 -m venv $(VENV)
	$(PIP) install --upgrade pip
	cd python-sdk && ../$(PIP) install -e ".[dev]"

test: test-php test-python

test-php:
	@echo "Running PHP tests..."
	@if command -v php >/dev/null 2>&1; then \
		./vendor/bin/phpunit; \
	else \
		echo "PHP not found, skipping PHP tests."; \
	fi

test-python:
	@echo "Running Python tests..."
	cd python-sdk && ../$(PYTHON) -m pytest

lint: lint-php lint-python

lint-php:
	@echo "Linting PHP..."
	./vendor/bin/phpstan analyse

lint-python:
	@echo "Linting Python..."
	cd python-sdk && ../$(PYTHON) -m flake8 klinkfinance_sdk && ../$(PYTHON) -m black --check klinkfinance_sdk && ../$(PYTHON) -m mypy klinkfinance_sdk

clean:
	@echo "Cleaning up..."
	rm -rf php-sdk/vendor
	rm -rf python-sdk/build python-sdk/dist python-sdk/*.egg-info python-sdk/__pycache__
