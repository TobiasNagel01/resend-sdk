<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Automation;

/**
 * Retrieve a single automation
 *
 * GET /automations/{automation_id}
 *
 * @generated from the Resend OpenAPI spec (automations/get). Do not edit by hand, run `composer generate` instead.
 */
class GetAutomationRequest extends Request
{
    protected Method $method = Method::GET;

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

    public function createDtoFromResponse(Response $response): Automation
    {
        return Automation::fromArray($response->json());
    }
}
