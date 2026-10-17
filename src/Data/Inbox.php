<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (inboxes/list, inboxes/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Inbox
{
    /**
     * @param  string  $id  The ID of the inbox.
     * @param  string|null  $name  Internal name for the inbox. Recipients do not see it.
     * @param  string  $emailAddress  The address of the inbox.
     * @param  string|null  $fromName  The name recipients see when mail is sent from this inbox. `null` when not set.
     * @param  int  $unread  The number of unread threads in the Inbox folder.
     * @param  string|null  $lastReceived  ISO 8601 timestamp of the newest received email in the Inbox folder. `null` when the folder has no received email.
     * @param  string  $createdAt  ISO 8601 timestamp when the inbox was created.
     * @param  string  $updatedAt  ISO 8601 timestamp when the inbox was last updated.
     * @param  string|null  $object  The object type. Always `inbox`.
     * @param  string|null  $domainId  The ID of the domain that owns the address.
     * @param  string|null  $receivingAddress  The address to forward mail to when forwarding is enabled. `null` otherwise.
     * @param  int|null  $drafts  The number of unsent drafts.
     */
    public function __construct(
        public string $id,
        public ?string $name,
        public string $emailAddress,
        public ?string $fromName,
        public int $unread,
        public ?string $lastReceived,
        public string $createdAt,
        public string $updatedAt,
        public ?string $object = null,
        public ?string $domainId = null,
        public ?string $receivingAddress = null,
        public ?int $drafts = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            emailAddress: $data['email_address'],
            fromName: $data['from_name'],
            unread: $data['unread'],
            lastReceived: $data['last_received'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            object: $data['object'] ?? null,
            domainId: $data['domain_id'] ?? null,
            receivingAddress: $data['receiving_address'] ?? null,
            drafts: $data['drafts'] ?? null,
        );
    }
}
