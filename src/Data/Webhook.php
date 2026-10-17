<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (webhooks/list, webhooks/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Webhook
{
    /**
     * @param  string|null  $id  The ID of the webhook.
     * @param  string|null  $endpoint  The URL where webhook events are sent.
     * @param  list<string>|null  $events  Array of event types subscribed to.
     * @param  string|null  $status  The status of the webhook.
     * @param  string|null  $createdAt  Timestamp indicating when the webhook was created.
     * @param  string|null  $object  The type of object.
     * @param  string|null  $signingSecret  The secret key used to verify webhook payloads.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $endpoint = null,
        public ?array $events = null,
        public ?string $status = null,
        public ?string $createdAt = null,
        public ?string $object = null,
        public ?string $signingSecret = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            endpoint: $data['endpoint'] ?? null,
            events: $data['events'] ?? null,
            status: $data['status'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
            signingSecret: $data['signing_secret'] ?? null,
        );
    }
}
