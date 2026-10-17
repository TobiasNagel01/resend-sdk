<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (contacts/list-imports, contacts/get-import). Do not edit by hand, run `composer generate` instead.
 */
final readonly class ContactImport
{
    /**
     * @param  string|null  $object  Type of the response object.
     * @param  string|null  $id  Unique identifier for the contact import.
     * @param  'queued'|'in_progress'|'completed'|'failed'|null  $status  Current status of the contact import.
     * @param  string|null  $createdAt  Timestamp indicating when the contact import was created.
     * @param  string|null  $completedAt  Timestamp indicating when the contact import completed.
     * @param  array{total?: int, created?: int, updated?: int, skipped?: int, failed?: int}|null  $counts
     */
    public function __construct(
        public ?string $object = null,
        public ?string $id = null,
        public ?string $status = null,
        public ?string $createdAt = null,
        public ?string $completedAt = null,
        public ?array $counts = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            object: $data['object'] ?? null,
            id: $data['id'] ?? null,
            status: $data['status'] ?? null,
            createdAt: $data['created_at'] ?? null,
            completedAt: $data['completed_at'] ?? null,
            counts: $data['counts'] ?? null,
        );
    }
}
