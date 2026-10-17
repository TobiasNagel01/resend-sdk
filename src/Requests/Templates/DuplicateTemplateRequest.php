<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Templates;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Duplicate a template
 *
 * POST /templates/{id}/duplicate
 *
 * @generated from the Resend OpenAPI spec (templates/duplicate). Do not edit by hand, run `composer generate` instead.
 */
class DuplicateTemplateRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $id  The Template ID or alias.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/templates/'.rawurlencode($this->id).'/duplicate';
    }
}
