<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Logs\GetLogRequest;
use TobiasNagel01\ResendSdk\Requests\Logs\ListLogsRequest;

/**
 * Logs endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Logs extends BaseResource
{
    /**
     * Retrieve a list of logs
     *
     * `$response->dto()` returns a ListResponse<Log>.
     *
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(?int $limit = null, ?string $after = null, ?string $before = null): Response
    {
        return $this->connector->send(new ListLogsRequest($limit, $after, $before));
    }

    /**
     * Retrieve a single log
     *
     * `$response->dto()` returns a Log.
     *
     * @param  string  $logId  The ID of the log.
     */
    public function get(string $logId): Response
    {
        return $this->connector->send(new GetLogRequest($logId));
    }
}
