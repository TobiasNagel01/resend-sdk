<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an automation
 *
 * PATCH /automations/{automation_id}
 *
 * @generated from the Resend OpenAPI spec (automations/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateAutomationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $automationId  The ID of the automation.
     * @param  string|null  $name  The name of the automation.
     * @param  'enabled'|'disabled'|null  $status  The status of the automation.
     * @param  list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>|null  $steps  The steps that compose the automation workflow. Must be provided together with `connections`.
     * @param  list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>|null  $connections  The connections between steps in the automation graph. Must be provided together with `steps`.
     */
    public function __construct(
        public readonly string $automationId,
        public readonly ?string $name = null,
        public readonly ?string $status = null,
        public readonly ?array $steps = null,
        public readonly ?array $connections = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations/'.rawurlencode($this->automationId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'status' => $this->status,
            'steps' => $this->steps,
            'connections' => $this->connections,
        ]);
    }
}
