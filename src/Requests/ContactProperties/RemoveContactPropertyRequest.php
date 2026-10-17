<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ContactProperties;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing contact property
 *
 * DELETE /contact-properties/{id}
 *
 * @generated from the Resend OpenAPI spec (contact-properties/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveContactPropertyRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $id  The Contact Property ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contact-properties/'.rawurlencode($this->id);
    }
}
