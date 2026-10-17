<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Inbox;

/**
 * Retrieve a single inbox by ID or email address
 *
 * GET /inboxes/{inbox_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/get). Do not edit by hand, run `composer generate` instead.
 */
class GetInboxRequest extends Request
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
        return '/inboxes/'.rawurlencode($this->inboxId);
    }

    public function createDtoFromResponse(Response $response): Inbox
    {
        return Inbox::fromArray($response->json());
    }
}
