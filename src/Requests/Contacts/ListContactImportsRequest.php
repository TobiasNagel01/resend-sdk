<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ContactImport;
use TobiasNagel01\ResendSdk\Data\ListResponse;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Retrieve a list of contact imports
 *
 * GET /contacts/imports
 *
 * @generated from the Resend OpenAPI spec (contacts/list-imports). Do not edit by hand, run `composer generate` instead.
 */
class ListContactImportsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  'queued'|'in_progress'|'completed'|'failed'|null  $status  Filter contact imports by status.
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
        return '/contacts/imports';
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
     * @return ListResponse<ContactImport>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), ContactImport::fromArray(...));
    }
}
