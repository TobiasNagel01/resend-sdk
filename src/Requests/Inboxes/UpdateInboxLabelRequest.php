<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing inbox label
 *
 * Renames or recolors a label. Omitted fields keep their current value. A new name must not match another label on the inbox, compared without case, or the request returns a 422 validation_error.
 *
 * PATCH /inboxes/{inbox_id}/labels/{label_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/update-label). Do not edit by hand, run `composer generate` instead.
 */
class UpdateInboxLabelRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string  $labelId  The Label ID.
     * @param  string|null  $name  A new name for the label. Max 64 characters. Leading and trailing whitespace is trimmed. Must not match another label on the inbox, compared without case.
     * @param  string|null  $color  A new color for the label, as a `#RRGGBB` hex color. It is stored in uppercase.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly string $labelId,
        public readonly ?string $name = null,
        public readonly ?string $color = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId).'/labels/'.rawurlencode($this->labelId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'color' => $this->color,
        ]);
    }
}
