<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (contact-properties/list, contact-properties/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class ContactProperty
{
    /**
     * @param  string|null  $id  Unique identifier for the contact property.
     * @param  string|null  $key  The property key.
     * @param  string|null  $type  The property type.
     * @param  string|int|float|null  $fallbackValue  The default value when the property is not set for a contact.
     * @param  string|null  $createdAt  Timestamp indicating when the contact property was created.
     * @param  string|null  $object  The object type.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $key = null,
        public ?string $type = null,
        public string|int|float|null $fallbackValue = null,
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
            key: $data['key'] ?? null,
            type: $data['type'] ?? null,
            fallbackValue: $data['fallback_value'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
