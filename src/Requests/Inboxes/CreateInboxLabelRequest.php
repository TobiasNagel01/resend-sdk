<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a label on an inbox
 *
 * A label is a named, colored tag that belongs to one inbox. An inbox can have at most 100 labels. Label names are unique per inbox, compared without case. A duplicate name or a full inbox returns a 422 validation_error.
 *
 * POST /inboxes/{inbox_id}/labels
 *
 * @generated from the Resend OpenAPI spec (inboxes/create-label). Do not edit by hand, run `composer generate` instead.
 */
class CreateInboxLabelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $name  The name of the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
     * @param  string|null  $color  The color of the label, as a `#RRGGBB` hex color. It is stored in uppercase. When omitted, a random color from the dashboard palette is used.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $name,
        public readonly ?string $color = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/labels';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'color' => $this->color,
        ]);
    }
}
