<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Suppressions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Remove up to 100 suppressions at once
 *
 * POST /suppressions/batch/remove
 *
 * @generated from the Resend OpenAPI spec (suppressions/batch-remove). Do not edit by hand, run `composer generate` instead.
 */
class BatchRemoveSuppressionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  list<string>|null  $emails  Email addresses to remove from the suppression list.
     * @param  list<string>|null  $ids  Suppression IDs to remove from the suppression list.
     */
    public function __construct(
        public readonly ?array $emails = null,
        public readonly ?array $ids = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/suppressions/batch/remove';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'emails' => $this->emails,
            'ids' => $this->ids,
        ]);
    }
}
