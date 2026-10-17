<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Stop an automation
 *
 * POST /automations/{automation_id}/stop
 *
 * @generated from the Resend OpenAPI spec (automations/stop). Do not edit by hand, run `composer generate` instead.
 */
class StopAutomationRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $automationId  The ID of the automation.
     */
    public function __construct(
        public readonly string $automationId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations/'.rawurlencode($this->automationId).'/stop';
    }
}
