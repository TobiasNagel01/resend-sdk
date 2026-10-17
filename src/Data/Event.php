<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (events/list, events/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Event
{
    /**
     * @param  string|null  $id  The event ID.
     * @param  string|null  $name  The event name.
     * @param  array<string, mixed>|null  $schema  A flat key/type map defining the event payload schema. Supported types are `string`, `number`, `boolean`, and `date`.
     * @param  string|null  $createdAt  The date and time the event was created.
     * @param  string|null  $updatedAt  The date and time the event was last updated.
     * @param  string|null  $object  Type of the response object.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?array $schema = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
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
            schema: $data['schema'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
