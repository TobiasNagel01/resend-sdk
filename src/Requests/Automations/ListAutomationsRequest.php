<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Automations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Automation;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of automations
 *
 * GET /automations
 *
 * @generated from the Resend OpenAPI spec (automations/list). Do not edit by hand, run `composer generate` instead.
 */
class ListAutomationsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  'enabled'|'disabled'|null  $status  Filter automations by status.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function __construct(
        public readonly ?string $status = null,
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/automations';
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
     * @return ListResponse<Automation>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Automation::fromArray(...));
    }
}
