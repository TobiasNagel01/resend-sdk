<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Email;

/**
 * Retrieve a single email
 *
 * GET /emails/{email_id}
 *
 * @generated from the Resend OpenAPI spec (emails/get). Do not edit by hand, run `composer generate` instead.
 */
class GetEmailRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $emailId  The ID of the email.
     */
    public function __construct(
        public readonly string $emailId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/'.rawurlencode($this->emailId);
    }

    public function createDtoFromResponse(Response $response): Email
    {
        return Email::fromArray($response->json());
    }
}
