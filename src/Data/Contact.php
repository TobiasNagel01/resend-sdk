<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (contacts/list, contacts/get, segments/list-contacts). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Contact
{
    /**
     * @param  string|null  $id  Unique identifier for the contact.
     * @param  string|null  $email  Email address of the contact.
     * @param  string|null  $firstName  First name of the contact.
     * @param  string|null  $lastName  Last name of the contact.
     * @param  string|null  $createdAt  Timestamp indicating when the contact was created.
     * @param  bool|null  $unsubscribed  Indicates if the contact is unsubscribed.
     * @param  string|null  $object  Type of the response object.
     * @param  array<string, mixed>|null  $properties  A map of custom property keys and values.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $email = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $createdAt = null,
        public ?bool $unsubscribed = null,
        public ?string $object = null,
        public ?array $properties = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            email: $data['email'] ?? null,
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            createdAt: $data['created_at'] ?? null,
            unsubscribed: $data['unsubscribed'] ?? null,
            object: $data['object'] ?? null,
            properties: $data['properties'] ?? null,
        );
    }
}
