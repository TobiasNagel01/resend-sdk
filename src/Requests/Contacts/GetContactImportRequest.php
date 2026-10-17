<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Contacts;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\ContactImport;

/**
 * Retrieve a single contact import
 *
 * GET /contacts/imports/{id}
 *
 * @generated from the Resend OpenAPI spec (contacts/get-import). Do not edit by hand, run `composer generate` instead.
 */
class GetContactImportRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Contact Import ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/contacts/imports/'.rawurlencode($this->id);
    }

    public function createDtoFromResponse(Response $response): ContactImport
    {
        return ContactImport::fromArray($response->json());
    }
}
