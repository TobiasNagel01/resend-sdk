<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Add up to 100 suppressions at once
 *
 * POST /suppressions/batch/add
 *
 * @generated from the Resend OpenAPI spec (suppressions/batch-add). Do not edit by hand, run `composer generate` instead.
 */
class BatchAddSuppressionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  list<string>  $emails  Email addresses to suppress.
     */
    public function __construct(
        public readonly array $emails,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions/batch/add';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'emails' => $this->emails,
        ]);
    }
}
