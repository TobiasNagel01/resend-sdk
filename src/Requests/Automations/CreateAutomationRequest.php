<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create an automation
 *
 * POST /automations
 *
 * @generated from the Resend OpenAPI spec (automations/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateAutomationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the automation.
     * @param  list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>  $steps  The steps that compose the automation workflow. Must include at least one `trigger` step.
     * @param  list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>  $connections  The connections between steps in the automation graph.
     * @param  'enabled'|'disabled'|null  $status  The initial status of the automation. Defaults to `disabled`.
     */
    public function __construct(
        public readonly string $name,
        public readonly array $steps,
        public readonly array $connections,
        public readonly ?string $status = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'steps' => $this->steps,
            'connections' => $this->connections,
            'status' => $this->status,
        ]);
    }
}
