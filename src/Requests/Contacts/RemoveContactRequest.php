<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing contact by ID or email
 *
 * DELETE /contacts/{id}
 *
 * @generated from the Resend OpenAPI spec (contacts/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveContactRequest extends Request
{
    protected Method $method = Method::DELETE;

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
}
