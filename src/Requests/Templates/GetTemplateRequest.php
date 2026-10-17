<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Templates;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Template;

/**
 * Retrieve a single template
 *
 * GET /templates/{id}
 *
 * @generated from the Resend OpenAPI spec (templates/get). Do not edit by hand, run `composer generate` instead.
 */
class GetTemplateRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $id  The Template ID or alias.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/templates/'.rawurlencode($this->id);
    }

    public function createDtoFromResponse(Response $response): Template
    {
        return Template::fromArray($response->json());
    }
}
