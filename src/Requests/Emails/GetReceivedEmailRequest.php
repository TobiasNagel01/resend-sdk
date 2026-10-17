<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Emails;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ReceivedEmail;

/**
 * Retrieve a single received email
 *
 * GET /emails/receiving/{email_id}
 *
 * @generated from the Resend OpenAPI spec (emails/get-receiving). Do not edit by hand, run `composer generate` instead.
 */
class GetReceivedEmailRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $emailId  The ID of the received email.
     */
    public function __construct(
        public readonly string $emailId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/emails/receiving/'.rawurlencode($this->emailId);
    }

    public function createDtoFromResponse(Response $response): ReceivedEmail
    {
        return ReceivedEmail::fromArray($response->json());
    }
}
