<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\ContactProperties;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ContactProperty;

/**
 * Retrieve a single contact property
 *
 * GET /contact-properties/{id}
 *
 * @generated from the Resend OpenAPI spec (contact-properties/get). Do not edit by hand, run `composer generate` instead.
 */
class GetContactPropertyRequest extends Request
{
    protected Method $method = Method::GET;

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

    public function createDtoFromResponse(Response $response): ContactProperty
    {
        return ContactProperty::fromArray($response->json());
    }
}
