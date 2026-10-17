<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ContactProperties;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update an existing contact property
 *
 * PATCH /contact-properties/{id}
 *
 * @generated from the Resend OpenAPI spec (contact-properties/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateContactPropertyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $id  The Contact Property ID.
     * @param  string|int|float|null  $fallbackValue  The default value to use when the property is not set for a contact. Must match the type of the property.
     */
    public function __construct(
        public readonly string $id,
        public readonly string|int|float|null $fallbackValue = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contact-properties/'.rawurlencode($this->id);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'fallback_value' => $this->fallbackValue,
        ]);
    }
}
