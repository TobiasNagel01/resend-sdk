<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update a single contact by ID or email
 *
 * PATCH /contacts/{id}
 *
 * @generated from the Resend OpenAPI spec (contacts/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  The Contact ID or email address.
     * @param  string|null  $email  Email address of the contact.
     * @param  string|null  $firstName  First name of the contact.
     * @param  string|null  $lastName  Last name of the contact.
     * @param  bool|null  $unsubscribed  The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
     * @param  array<string, mixed>|null  $properties  A map of custom property keys and values to update.
     */
    public function __construct(
        public readonly string $id,
        public readonly ?string $email = null,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?bool $unsubscribed = null,
        public readonly ?array $properties = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'unsubscribed' => $this->unsubscribed,
            'properties' => $this->properties,
        ]);
    }
}
