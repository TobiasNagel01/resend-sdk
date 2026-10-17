<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (segments/list, segments/get, contacts/list-segments). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Segment
{
    /**
     * @param  string|null  $id  Unique identifier for the segment.
     * @param  string|null  $name  Name of the segment.
     * @param  string|null  $audienceId  The ID of the audience this segment belongs to.
     * @param  string|null  $createdAt  Timestamp indicating when the segment was created.
     * @param  string|null  $object  The object type.
     * @param  array<string, mixed>|null  $filter  Filter conditions for the segment.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $audienceId = null,
        public ?string $createdAt = null,
        public ?string $object = null,
        public ?array $filter = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            audienceId: $data['audience_id'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
            filter: $data['filter'] ?? null,
        );
    }
}
