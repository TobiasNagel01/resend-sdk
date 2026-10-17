<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Duplicate an automation
 *
 * POST /automations/{automation_id}/duplicate
 *
 * @generated from the Resend OpenAPI spec (automations/duplicate). Do not edit by hand, run `composer generate` instead.
 */
class DuplicateAutomationRequest extends Request
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
        return '/automations/'.rawurlencode($this->automationId).'/duplicate';
    }
}
