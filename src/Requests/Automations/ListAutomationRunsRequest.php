<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\AutomationRun;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of automation runs
 *
 * GET /automations/{automation_id}/runs
 *
 * @generated from the Resend OpenAPI spec (automations/list-runs). Do not edit by hand, run `composer generate` instead.
 */
class ListAutomationRunsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $automationId  The ID of the automation.
     * @param  string|null  $status  Filter runs by status. Comma-separated list of: running, completed, failed, cancelled.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly string $automationId,
        public readonly ?string $status = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations/'.rawurlencode($this->automationId).'/runs';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'status' => $this->status,
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<AutomationRun>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), AutomationRun::fromArray(...));
    }
}
