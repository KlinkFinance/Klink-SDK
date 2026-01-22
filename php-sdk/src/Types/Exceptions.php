<?php

declare(strict_types=1);

namespace KlinkFinance\SDK\Types;

use Exception;

/**
 * Base exception class for all Klink SDK errors
 */
class KlinkException extends Exception
{
}

/**
 * Configuration validation errors
 */
class KlinkConfigException extends KlinkException
{
}

/**
 * Authentication and authorization errors
 */
class KlinkAuthException extends KlinkException
{
}

/**
 * API errors with status codes
 */
class KlinkAPIException extends KlinkException
{
    private int $statusCode;
    private ?array $responseData;

    public function __construct(
        string $message,
        int $statusCode,
        ?array $responseData = null,
        ?Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseData(): ?array
    {
        return $this->responseData;
    }
}

/**
 * Network and connectivity errors
 */
class KlinkNetworkException extends KlinkException
{
}
