<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update topics for a contact
 *
 * PATCH /contacts/{contact_id}/topics
 *
 * @generated from the Resend OpenAPI spec (contacts/update-topics). Do not edit by hand, run `composer generate` instead.
 */
class UpdateContactTopicsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $contactId  The Contact ID or email address.
     * @param  list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>  $topics
     */
    public function __construct(
        public readonly string $contactId,
        public readonly array $topics,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->contactId).'/topics';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'topics' => $this->topics,
        ]);
    }
}
