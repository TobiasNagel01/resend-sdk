<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Topics;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Topic;

/**
 * Retrieve a single topic
 *
 * GET /topics/{id}
 *
 * @generated from the Resend OpenAPI spec (topics/get). Do not edit by hand, run `composer generate` instead.
 */
class GetTopicRequest extends Request
{
    protected Method $method = Method::GET;

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

    public function createDtoFromResponse(Response $response): Topic
    {
        return Topic::fromArray($response->json());
    }
}
