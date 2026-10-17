<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing inbox by ID or email address
 *
 * Updates the internal name of the inbox or the name recipients see when mail is sent from it. At least one of `name` or `from_name` is required.
 *
 * PATCH /inboxes/{inbox_id}
 *
 * @generated from the Resend OpenAPI spec (inboxes/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateInboxRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $inboxId  The Inbox ID or the inbox email address, such as `support@acme.com`. A value that contains `@` must be a valid email address, and any other value must be a UUID, or the request returns a 422. The address match is case-insensitive and never falls back to the inbox `name`. An address that matches no inbox returns a 404.
     * @param  string|null  $name  New internal name for the inbox. Recipients do not see it. Between 1 and 64 characters after trimming.
     * @param  string|null  $fromName  The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string removes it.
     */
    public function __construct(
        public readonly string $inboxId,
        public readonly ?string $name = null,
        public readonly ?string $fromName = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes/'.rawurlencode($this->inboxId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
            'from_name' => $this->fromName,
        ]);
    }
}
