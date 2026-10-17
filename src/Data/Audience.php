<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (audiences/list, audiences/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Audience
{
    /**
     * @param  string|null  $id  Unique identifier for the audience.
     * @param  string|null  $name  Name of the audience.
     * @param  string|null  $createdAt  Timestamp indicating when the audience was created.
     * @param  string|null  $object  The object of the audience.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $createdAt = null,
        public ?string $object = null,
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
            object: $data['object'] ?? null,
        );
    }
}
