<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Inboxes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create an inbox
 *
 * Creates an inbox that sends and receives email at an address on one of your domains. The domain must belong to the team. Without `forwarding`, the domain must have receiving enabled, with DKIM and SPF verified and the inbound MX record verified or pending. With `forwarding` set to `true`, the domain only needs DKIM and SPF verified for sending, and Resend generates a `receiving_address` on the team inbound domain, and a team without an inbound domain gets a 422. A domain that does not meet these rules returns a 422 validation_error. An address or receiving address that is already in use returns a 409. A team that has reached the inbox limit of its plan returns a 403 validation_error. A blocked account returns a 451.
 *
 * POST /inboxes
 *
 * @generated from the Resend OpenAPI spec (inboxes/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateInboxRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $emailAddress  The inbox email address on one of your domains. The API trims and lowercases it. The part before the `@` is at most 64 characters and contains only letters, numbers, and `. _ % -`. A `+` returns a 422. It cannot start or end with a dot or contain two dots in a row.
     * @param  string|null  $name  Internal name for the inbox. Recipients do not see it. Max 64 characters. Defaults to `email_address`.
     * @param  string|null  $fromName  The name recipients see when mail is sent from this inbox. A plain name, not a `Name <email>` address. Max 78 characters. It cannot contain a colon, `<`, `>`, line breaks, or other control characters. An email address inside the name must be on a domain the team has verified for sending. An empty string leaves it unset.
     * @param  bool|null  $forwarding  When `true`, Resend provisions a receiving address so you can receive mail without adding an MX record. The address is returned in `receiving_address`.
     */
    public function __construct(
        public readonly string $emailAddress,
        public readonly ?string $name = null,
        public readonly ?string $fromName = null,
        public readonly ?bool $forwarding = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inboxes';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'email_address' => $this->emailAddress,
            'name' => $this->name,
            'from_name' => $this->fromName,
            'forwarding' => $this->forwarding,
        ]);
    }
}
