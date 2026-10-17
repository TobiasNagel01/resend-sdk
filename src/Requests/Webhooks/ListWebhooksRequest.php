<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Data\Webhook;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of webhooks
 *
 * GET /webhooks
 *
 * @generated from the Resend OpenAPI spec (webhooks/list). Do not edit by hand, run `composer generate` instead.
 */
class ListWebhooksRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  int|null  $limit  Maximum number of webhooks to return.
     * @param  string|null  $after  Pagination cursor to fetch results after this webhook ID. Cannot be used with 'before'.
     * @param  string|null  $before  Pagination cursor to fetch results before this webhook ID. Cannot be used with 'after'.
     */
    public function __construct(
        public readonly ?int $limit = null,
        public readonly ?string $after = null,
        public readonly ?string $before = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/webhooks';
    }

    protected function defaultQuery(): array
    {
        return Payload::query([
            'limit' => $this->limit,
            'after' => $this->after,
            'before' => $this->before,
        ]);
    }

    /**
     * @return ListResponse<Webhook>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), Webhook::fromArray(...));
    }
}
