<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\AutomationRun;

/**
 * Retrieve a single automation run
 *
 * GET /automations/{automation_id}/runs/{run_id}
 *
 * @generated from the Resend OpenAPI spec (automations/get-run). Do not edit by hand, run `composer generate` instead.
 */
class GetAutomationRunRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $automationId  The ID of the automation.
     * @param  string  $runId  The ID of the automation run.
     */
    public function __construct(
        public readonly string $automationId,
        public readonly string $runId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations/'.rawurlencode($this->automationId).'/runs/'.rawurlencode($this->runId);
    }

    public function createDtoFromResponse(Response $response): AutomationRun
    {
        return AutomationRun::fromArray($response->json());
    }
}
