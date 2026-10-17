<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Requests\Logs;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Data\Log;

/**
 * Retrieve a single log
 *
 * GET /logs/{log_id}
 *
 * @generated from the Resend OpenAPI spec (logs/get). Do not edit by hand, run `composer generate` instead.
 */
class GetLogRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $logId  The ID of the log.
     */
    public function __construct(
        public readonly string $logId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/logs/'.rawurlencode($this->logId);
    }

    public function createDtoFromResponse(Response $response): Log
    {
        return Log::fromArray($response->json());
    }
}
