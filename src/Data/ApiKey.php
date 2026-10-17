<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (api-keys/list). Do not edit by hand, run `composer generate` instead.
 */
final readonly class ApiKey
{
    /**
     * @param  string|null  $id  The ID of the API key.
     * @param  string|null  $name  The name of the API key.
     * @param  string|null  $createdAt  The date and time the API key was created.
     * @param  string|null  $lastUsedAt  The date and time the API key was last used.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $createdAt = null,
        public ?string $lastUsedAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            createdAt: $data['created_at'] ?? null,
            lastUsedAt: $data['last_used_at'] ?? null,
        );
    }
}
