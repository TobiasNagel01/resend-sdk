<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Contact;

/**
 * Retrieve a single contact by ID or email
 *
 * GET /contacts/{id}
 *
 * @generated from the Resend OpenAPI spec (contacts/get). Do not edit by hand, run `composer generate` instead.
 */
class GetContactRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Contact ID or email address.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/'.rawurlencode($this->id);
    }

    public function createDtoFromResponse(Response $response): Contact
    {
        return Contact::fromArray($response->json());
    }
}
