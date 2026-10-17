<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new contact
 *
 * POST /contacts
 *
 * @generated from the Resend OpenAPI spec (contacts/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $email  Email address of the contact.
     * @param  string|null  $firstName  First name of the contact.
     * @param  string|null  $lastName  Last name of the contact.
     * @param  bool|null  $unsubscribed  The Contact's global subscription status. If set to true, the contact will be unsubscribed from all Broadcasts.
     * @param  array<string, mixed>|null  $properties  A map of custom property keys and values to create.
     * @param  list<array{id?: string}>|null  $segments  Array of segment IDs to add the contact to.
     * @param  list<array{id?: string, subscription?: 'opt_in'|'opt_out'}>|null  $topics  Array of topic subscriptions for the contact.
     * @param  string|null  $audienceId  Unique identifier of the audience to which the contact belongs.
     */
    public function __construct(
        public readonly string $email,
        public readonly ?string $firstName = null,
        public readonly ?string $lastName = null,
        public readonly ?bool $unsubscribed = null,
        public readonly ?array $properties = null,
        public readonly ?array $segments = null,
        public readonly ?array $topics = null,
        public readonly ?string $audienceId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'unsubscribed' => $this->unsubscribed,
            'properties' => $this->properties,
            'segments' => $this->segments,
            'topics' => $this->topics,
            'audience_id' => $this->audienceId,
        ]);
    }
}
