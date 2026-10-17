<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (webhooks/list-events, webhooks/get-event). Do not edit by hand, run `composer generate` instead.
 */
final readonly class WebhookEvent
{
    /**
     * @param  string|null  $id  The ID of the webhook event.
     * @param  string|null  $type  The type of the event.
     * @param  string|null  $createdAt  Timestamp indicating when the event was created.
     * @param  'pending'|'attempting'|'success'|'failed'|null  $status  The delivery status of the event for this webhook.
     * @param  string|null  $object  The type of object.
     * @param  string|null  $nextAttemptAt  Timestamp of the next scheduled delivery attempt, or null when none is scheduled. Always null once the event has succeeded or permanently failed.
     * @param  array<string, mixed>|null  $payload  The event payload sent to the webhook endpoint.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $type = null,
        public ?string $createdAt = null,
        public ?string $status = null,
        public ?string $object = null,
        public ?string $nextAttemptAt = null,
        public ?array $payload = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            type: $data['type'] ?? null,
            createdAt: $data['created_at'] ?? null,
            status: $data['status'] ?? null,
            object: $data['object'] ?? null,
            nextAttemptAt: $data['next_attempt_at'] ?? null,
            payload: $data['payload'] ?? null,
        );
    }
}
