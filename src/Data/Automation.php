<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (automations/list, automations/get). Do not edit by hand, run `composer generate` instead.
 */
final readonly class Automation
{
    /**
     * @param  string|null  $id  The ID of the automation.
     * @param  string|null  $name  The name of the automation.
     * @param  'enabled'|'disabled'|null  $status  The current status of the automation.
     * @param  string|null  $createdAt  The date and time the automation was created.
     * @param  string|null  $updatedAt  The date and time the automation was last updated.
     * @param  string|null  $object  Type of the response object.
     * @param  list<array{key?: string, type?: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config?: array<string, mixed>}>|null  $steps  The steps in the active version of the automation.
     * @param  list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>|null  $connections  The connections between steps in the active version of the automation.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $status = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?string $object = null,
        public ?array $steps = null,
        public ?array $connections = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            status: $data['status'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            object: $data['object'] ?? null,
            steps: $data['steps'] ?? null,
            connections: $data['connections'] ?? null,
        );
    }
}
