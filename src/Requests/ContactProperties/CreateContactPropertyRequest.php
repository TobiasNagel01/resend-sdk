<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ContactProperties;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a new contact property
 *
 * POST /contact-properties
 *
 * @generated from the Resend OpenAPI spec (contact-properties/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateContactPropertyRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $key  The property key. Max length is 50 characters. Only alphanumeric characters and underscores are allowed.
     * @param  'string'|'number'  $type  The property type.
     * @param  string|int|float|null  $fallbackValue  The default value to use when the property is not set for a contact. Must match the type specified in the type field.
     */
    public function __construct(
        public readonly string $key,
        public readonly string $type,
        public readonly string|int|float|null $fallbackValue = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contact-properties';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'key' => $this->key,
            'type' => $this->type,
            'fallback_value' => $this->fallbackValue,
        ]);
    }
}
