<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete an automation
 *
 * DELETE /automations/{automation_id}
 *
 * @generated from the Resend OpenAPI spec (automations/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveAutomationRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $automationId  The ID of the automation.
     */
    public function __construct(
        public readonly string $automationId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations/'.rawurlencode($this->automationId);
    }
}
