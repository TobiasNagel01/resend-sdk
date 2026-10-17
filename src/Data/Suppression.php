<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (suppressions/list, suppressions/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Suppression
{
    /**
     * @param  string|null  $id  Unique identifier for the suppression.
     * @param  string|null  $email  Email address that is suppressed.
     * @param  'bounce'|'complaint'|'manual'|null  $origin  Origin of the suppression.
     * @param  string|null  $sourceId  Identifier of the event that caused the suppression, such as the email that bounced or complained.
     * @param  string|null  $createdAt  Timestamp indicating when the suppression was created.
     * @param  string|null  $object  Type of the response object.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $email = null,
        public ?string $origin = null,
        public ?string $sourceId = null,
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
            email: $data['email'] ?? null,
            origin: $data['origin'] ?? null,
            sourceId: $data['source_id'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
