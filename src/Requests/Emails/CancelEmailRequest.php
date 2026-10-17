<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Email;

/**
 * Cancel the schedule of the e-mail.
 *
 * POST /emails/{email_id}/cancel
 *
 * @generated from the Resend OpenAPI spec (emails/cancel). Do not edit by hand, run `composer generate` instead.
 */
class CancelEmailRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $emailId  The ID of the email.
     */
    public function __construct(
        public readonly string $emailId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/'.rawurlencode($this->emailId).'/cancel';
    }

    public function createDtoFromResponse(Response $response): Email
    {
        return Email::fromArray($response->json());
    }
}
