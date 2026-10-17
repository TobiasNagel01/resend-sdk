<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Suppressions\AddSuppressionRequest;
use TobiasNagel01\ResendSdk\Requests\Suppressions\BatchAddSuppressionsRequest;
use TobiasNagel01\ResendSdk\Requests\Suppressions\BatchRemoveSuppressionsRequest;
use TobiasNagel01\ResendSdk\Requests\Suppressions\GetSuppressionRequest;
use TobiasNagel01\ResendSdk\Requests\Suppressions\ListSuppressionsRequest;
use TobiasNagel01\ResendSdk\Requests\Suppressions\RemoveSuppressionRequest;

/**
 * Suppressions endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Suppressions extends BaseResource
{
    /**
     * Create a suppression
     *
     * @param  string  $email  Email address to suppress.
     */
    public function add(string $email): Response
    {
        return $this->connector->send(new AddSuppressionRequest($email));
    }

    /**
     * Retrieve a list of suppressions
     *
     * `$response->dto()` returns a ListResponse<Suppression>.
     *
     * @param  'bounce'|'complaint'|'manual'|null  $origin  Filter suppressions by origin.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(
        ?string $origin = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListSuppressionsRequest(
            $origin,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Add up to 100 suppressions at once
     *
     * @param  list<string>  $emails  Email addresses to suppress.
     */
    public function batchAdd(array $emails): Response
    {
        return $this->connector->send(new BatchAddSuppressionsRequest($emails));
    }

    /**
     * Remove up to 100 suppressions at once
     *
     * @param  list<string>|null  $emails  Email addresses to remove from the suppression list.
     * @param  list<string>|null  $ids  Suppression IDs to remove from the suppression list.
     */
    public function batchRemove(?array $emails = null, ?array $ids = null): Response
    {
        return $this->connector->send(new BatchRemoveSuppressionsRequest($emails, $ids));
    }

    /**
     * Retrieve a single suppression by ID or email
     *
     * `$response->dto()` returns a Suppression.
     *
     * @param  string  $suppression  The Suppression ID or email address.
     */
    public function get(string $suppression): Response
    {
        return $this->connector->send(new GetSuppressionRequest($suppression));
    }

    /**
     * Remove a single suppression by ID or email
     *
     * @param  string  $suppression  The Suppression ID or email address.
     */
    public function remove(string $suppression): Response
    {
        return $this->connector->send(new RemoveSuppressionRequest($suppression));
    }
}
