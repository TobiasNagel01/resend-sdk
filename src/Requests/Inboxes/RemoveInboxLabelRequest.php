<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing inbox label
 *
 * Deletes the label and removes it from every thread that carries it.
 *
 * DELETE /inboxes/{inbox_id}/labels/{label_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/remove-label). Do not edit by hand, run `composer generate` instead.
 */
class RemoveInboxLabelRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $labelId  The Label ID.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $labelId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/labels/'.rawurlencode($this->labelId);
    }
}
