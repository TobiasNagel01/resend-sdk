<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Topics;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Remove an existing topic
 *
 * DELETE /topics/{id}
 *
 * @generated from the Resend OpenAPI spec (topics/remove). Do not edit by hand, run `composer generate` instead.
 */
class RemoveTopicRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $id  The Topic ID.
     */
    public function __construct(
        public readonly string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/topics/'.rawurlencode($this->id);
    }
}
