<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (inboxes/list-labels). Do not edit by hand, run `composer generate` instead.
 */
final readonly class InboxLabel
{
    /**
     * @param  string  $id  The ID of the label.
     * @param  string  $name  The name of the label.
     * @param  string  $color  The color of the label, as a `#RRGGBB` hex color in uppercase.
     * @param  string  $createdAt  Timestamp when the label was created.
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $color,
        public string $createdAt,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            color: $data['color'],
            createdAt: $data['created_at'],
        );
    }
}
