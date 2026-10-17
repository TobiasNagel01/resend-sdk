<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Update a single email
 *
 * PATCH /emails/{email_id}
 *
 * @generated from the Resend OpenAPI spec (emails/update). Do not edit by hand, run `composer generate` instead.
 */
class UpdateEmailRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param  string  $emailId  The ID of the email.
     * @param  string  $scheduledAt  Schedule email to be sent later. The date should be in ISO 8601 format (e.g: 2024-08-05T11:52:01.858Z) or natural language (e.g.: "in 1 min").
     */
    public function __construct(
        public readonly string $emailId,
        public readonly string $scheduledAt,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/'.rawurlencode($this->emailId);
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'scheduled_at' => $this->scheduledAt,
        ]);
    }
}
