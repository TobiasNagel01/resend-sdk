<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Audiences;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a list of contacts
 *
 * Deprecated: Use Segments instead. These endpoints still work, but will be removed in the future.
 *
 * @deprecated
 *
 * POST /audiences
 *
 * @generated from the Resend OpenAPI spec (audiences/create). Do not edit by hand, run `composer generate` instead.
 */
class CreateAudienceRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $name  The name of the audience you want to create.
     */
    public function __construct(
        public readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/audiences';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'name' => $this->name,
        ]);
    }
}
