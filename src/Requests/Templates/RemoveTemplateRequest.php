<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Templates;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing template
 *
 * DELETE /templates/{id}
 *
 * @generated from the Resend OpenAPI spec (templates/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveTemplateRequest extends Request
{
    protected Method $method = Method::DELETE;

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
}
