<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (topics/list, topics/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Topic
{
    /**
     * @param  string|null  $id  Unique identifier for the topic.
     * @param  string|null  $name  Name of the topic.
     * @param  string|null  $description  A description of the topic.
     * @param  'opt_in'|'opt_out'|null  $defaultSubscription  The default subscription status for the topic.
     * @param  'public'|'private'|null  $visibility  The visibility of the topic.
     * @param  string|null  $createdAt  Timestamp indicating when the topic was created.
     * @param  string|null  $object  The object type.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $defaultSubscription = null,
        public ?string $visibility = null,
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
            description: $data['description'] ?? null,
            defaultSubscription: $data['default_subscription'] ?? null,
            visibility: $data['visibility'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
        );
    }
}
