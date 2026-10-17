<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use TobiasNagel01\ResendSdk\Support\Payload;

/**
 * Create a shareable link for a sent or received email.
 *
 * POST /emails/{email_id}/share
 *
 * @generated from the Resend OpenAPI spec (emails/share). Do not edit by hand, run `composer generate` instead.
 */
class ShareEmailRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $emailId  The ID of the email.
     * @param  string|null  $expiresIn  How long the link stays valid for, as a duration like `10m`, `2 hours`, or `1 day`. Defaults to `48h` and cannot exceed 48 hours.
     */
    public function __construct(
        public readonly string $emailId,
        public readonly ?string $expiresIn = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/'.rawurlencode($this->emailId).'/share';
    }

    protected function defaultBody(): array
    {
        return Payload::body([
            'expires_in' => $this->expiresIn,
        ]);
    }
}
