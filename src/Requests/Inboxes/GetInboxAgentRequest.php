<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieve the agent settings for an inbox
 *
 * Returns the agent settings of the inbox. An inbox without a configured agent returns empty settings: `instructions` and `tone` are null and `actions` is an empty array.
 *
 * GET /inboxes/{inbox_id}/agent
 *
 * @generated from the Resend OpenAPI spec (inboxes/get-agent). Do not edit by hand, run `composer generate` instead.
 */
class GetInboxAgentRequest extends Request
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
        return '/inboxes/'.rawurlencode($this->inboxId).'/agent';
    }
}
