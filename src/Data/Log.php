<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (logs/list, logs/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Log
{
    /**
     * @param  string|null  $id  The log ID.
     * @param  string|null  $createdAt  The date the log was created.
     * @param  string|null  $endpoint  The API endpoint that was called.
     * @param  'GET'|'POST'|'PUT'|'DELETE'|'PATCH'|'OPTIONS'|null  $method  The HTTP method used.
     * @param  int|null  $responseStatus  The HTTP status code of the response.
     * @param  string|null  $userAgent  The user agent of the request.
     * @param  string|null  $object  Type of the response object.
     * @param  array<string, mixed>|null  $requestBody  The request body sent to the API.
     * @param  array<string, mixed>|null  $responseBody  The response body returned by the API.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $createdAt = null,
        public ?string $endpoint = null,
        public ?string $method = null,
        public ?int $responseStatus = null,
        public ?string $userAgent = null,
        public ?string $object = null,
        public ?array $requestBody = null,
        public ?array $responseBody = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            createdAt: $data['created_at'] ?? null,
            endpoint: $data['endpoint'] ?? null,
            method: $data['method'] ?? null,
            responseStatus: $data['response_status'] ?? null,
            userAgent: $data['user_agent'] ?? null,
            object: $data['object'] ?? null,
            requestBody: $data['request_body'] ?? null,
            responseBody: $data['response_body'] ?? null,
        );
    }
}
