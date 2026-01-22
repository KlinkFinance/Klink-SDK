# Publishing Guide

This guide explains how to publish the Klink Finance SDKs to their respective package registries (Packagist for PHP and PyPI for Python).

## Prerequisites

1.  **GitHub Account**: You need access to the GitHub repository.
2.  **PyPI Account**: For publishing the Python SDK.
3.  **Packagist Account**: For publishing the PHP SDK.

## 1. Python SDK (PyPI)

The Python SDK publishing process is automated via GitHub Actions, but requires initial setup.

### Initial Setup (One-time)

1.  Log in to [PyPI](https://pypi.org/).
2.  Go to **Account settings** > **API tokens**.
3.  Create a new API token (scope it to "Entire account" if it's your first time, or the specific project if it exists).
4.  Copy the token.
5.  Go to your GitHub Repository > **Settings** > **Secrets and variables** > **Actions**.
6.  Click **New repository secret**.
    *   **Name**: `PYPI_API_TOKEN`
    *   **Value**: (Paste your PyPI token starting with `pypi-`)
7.  Click **Add secret**.

### How to Publish

To publish a new version:

1.  Update the version number in `python-sdk/pyproject.toml` (and `setup.py` if you are keeping them in sync):
    ```toml
    version = "1.0.1" # Increment this in pyproject.toml
    ```
2.  Create a new Release in GitHub:
    *   Go to **Releases** > **Draft a new release**.
    *   **Tag version**: `v1.0.1` (Must match the version in setup.py).
    *   **Title**: `Release v1.0.1`.
    *   **Description**: Add release notes.
    *   Click **Publish release**.

The [Publish Python SDK](.github/workflows/publish-python.yml) workflow will automatically run, build the package, and upload it to PyPI.

## 2. PHP SDK (Packagist)

The PHP SDK uses Packagist, which automatically syncs with GitHub.

### Initial Setup (One-time)

1.  Log in to [Packagist](https://packagist.org/).
2.  Click **Submit**.
3.  Enter your GitHub repository URL (e.g., `https://github.com/KlinkFinance/klink-sdk`).
4.  Click **Check** and then **Submit**.
5.  **Set up Auto-Update**:
    *   Packagist recommends setting up a GitHub Webhook so it knows when you push code.
    *   Get your API Token from Packagist Profile.
    *   Go to GitHub Repo > **Settings** > **Webhooks** > **Add webhook**.
    *   **Payload URL**: `https://packagist.org/api/github`
    *   **Content type**: `application/json`
    *   **Secret**: (Your Packagist API Token)
    *   **Just the push event**.
    *   Click **Add webhook**.

### How to Publish

To publish a new version:

1.  Update the version (optional but recommended for consistency) in `php-sdk/composer.json` (if you are manually managing versions there, though Packagist relies mostly on Git tags).
2.  Create a new Release in GitHub (same steps as Python):
    *   **Tag version**: `v1.0.1`.
    *   Click **Publish release**.

Packagist will automatically detect the new tag and make the version available to `composer`.

## 3. Monorepo Considerations

Since both SDKs share the same repository:

*   **Versioning**: It is recommended to keep version numbers synchronized between PHP and Python SDKs (e.g., release `v1.0.1` updates both), even if only one changed. This simplifies release management.
*   **Tagging**: When you create a GitHub Release (e.g., `v1.0.0`), it applies to the entire repo.
    *   **Python**: The workflow triggers on the release and publishes to PyPI.
    *   **PHP**: Packagist sees the tag and updates the package.

## Checklist Before Release

- [ ] Run tests: `make test`
- [ ] Update `CHANGELOG.md`
- [ ] Update version in `python-sdk/setup.py`
- [ ] Commit and push changes
- [ ] Draft and publish GitHub Release
