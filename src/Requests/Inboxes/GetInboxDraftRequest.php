<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\InboxDraft;

/**
 * Retrieve a single draft
 *
 * GET /inboxes/{inbox_id}/drafts/{draft_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/get-draft). Do not edit by hand, run `composer generate` instead.
 */
class GetInboxDraftRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $draftId  The Draft ID.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $draftId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/drafts/'.rawurlencode($this->draftId);
    }

    public function createDtoFromResponse(Response $response): InboxDraft
    {
        return InboxDraft::fromArray($response->json());
    }
}
