<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (schema:TemplateVariable). Do not edit by hand, run `composer generate` instead.
 */
final readonly class TemplateVariable
{
    /**
     * @param  string  $key  The key of the variable.
     * @param  'string'|'number'|'boolean'|'object'|'list'  $type  The type of the variable.
     * @param  string|null  $id  The ID of the template variable.
     * @param  string|int|float|bool|array<string, mixed>|list<mixed>|null  $fallbackValue  The fallback value of the variable.
     * @param  string|null  $createdAt  Timestamp indicating when the variable was created.
     * @param  string|null  $updatedAt  Timestamp indicating when the variable was last updated.
     */
    public function __construct(
        public string $key,
        public string $type,
        public ?string $id = null,
        public string|int|float|bool|array|null $fallbackValue = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: $data['key'],
            type: $data['type'],
            id: $data['id'] ?? null,
            fallbackValue: $data['fallback_value'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
