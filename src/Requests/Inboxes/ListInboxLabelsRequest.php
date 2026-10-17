<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\InboxLabel;
use TobiasNagel01\ResendSdk\Data\ListResponse;

/**
 * Retrieve a list of inbox labels
 *
 * Returns every label on the inbox, oldest first. The list is not paginated.
 *
 * GET /inboxes/{inbox_id}/labels
 *
 * @generated from the Resend OpenAPI spec (inboxes/list-labels). Do not edit by hand, run `composer generate` instead.
 */
class ListInboxLabelsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     */
    public function __construct(
        public readonly string $inboxId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/labels';
    }

    /**
     * @return ListResponse<InboxLabel>
     */
    public function createDtoFromResponse(Response $response): ListResponse
    {
        return ListResponse::fromArray($response->json(), InboxLabel::fromArray(...));
    }
}
