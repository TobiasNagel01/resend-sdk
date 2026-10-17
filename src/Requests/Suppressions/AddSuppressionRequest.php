<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a suppression
 *
 * POST /suppressions
 *
 * @generated from the Resend OpenAPI spec (suppressions/add). Do not edit by hand, run `composer generate` instead.
 */
class AddSuppressionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $email  Email address to suppress.
     */
    public function __construct(
        public readonly string $email,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'email' => $this->email,
        ]);
    }
}
