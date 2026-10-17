<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Data;

/**
 * @generated from the Resend OpenAPI spec (automations/list-runs, automations/get-run). Do not edit by hand, run `composer generate` instead.
 */
final readonly class AutomationRun
{
    /**
     * @param  string|null  $id  The ID of the automation run.
     * @param  'running'|'completed'|'failed'|'cancelled'|null  $status  The current status of the automation run.
     * @param  string|null  $startedAt  The date and time the run started.
     * @param  string|null  $completedAt  The date and time the run completed.
     * @param  string|null  $createdAt  The date and time the run was created.
     * @param  string|null  $object  Type of the response object.
     * @param  list<array{key?: string, type?: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', status?: string, started_at?: string, completed_at?: string, output?: array<string, mixed>, error?: array<string, mixed>, created_at?: string}>|null  $steps  The steps executed in this run, sorted in graph order.
     */
    public function __construct(
        public ?string $id = null,
        public ?string $status = null,
        public ?string $startedAt = null,
        public ?string $completedAt = null,
        public ?string $createdAt = null,
        public ?string $object = null,
        public ?array $steps = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            status: $data['status'] ?? null,
            startedAt: $data['started_at'] ?? null,
            completedAt: $data['completed_at'] ?? null,
            createdAt: $data['created_at'] ?? null,
            object: $data['object'] ?? null,
            steps: $data['steps'] ?? null,
        );
    }
}
