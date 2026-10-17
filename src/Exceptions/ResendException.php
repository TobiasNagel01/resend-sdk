<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Exceptions;

use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use Throwable;

/**
 * Thrown for every failed Resend API response.
 *
 * Resend errors look like {"statusCode": 422, "name": "validation_error", "message": "..."}.
 */
class ResendException extends RequestException
{
    public readonly ?string $errorName;

    public readonly ?string $errorMessage;

    public function __construct(Response $response, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        try {
            $body = $response->json();
        } catch (Throwable) {
            $body = [];
        }

        $body = is_array($body) ? $body : [];

        $this->errorName = isset($body['name']) && is_string($body['name']) ? $body['name'] : null;
        $this->errorMessage = isset($body['message']) && is_string($body['message']) ? $body['message'] : null;

        if ($message === null && $this->errorMessage !== null) {
            $message = sprintf('Resend API error (%d%s): %s', $response->status(), $this->errorName ? ', '.$this->errorName : '', $this->errorMessage);
        }

        parent::__construct($response, $message, $code ?: $response->status(), $previous);
    }

    public static function fromResponse(Response $response, ?Throwable $previous = null): self
    {
        return new self($response, previous: $previous);
    }

    public function statusCode(): int
    {
        return $this->getResponse()->status();
    }
}
