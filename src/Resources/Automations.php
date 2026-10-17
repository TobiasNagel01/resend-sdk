<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use TobiasNagel01\ResendSdk\Requests\Automations\CreateAutomationRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\DuplicateAutomationRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\GetAutomationRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\GetAutomationRunRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\ListAutomationRunsRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\ListAutomationsRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\RemoveAutomationRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\StopAutomationRequest;
use TobiasNagel01\ResendSdk\Requests\Automations\UpdateAutomationRequest;

/**
 * Automations endpoints of the Resend API.
 *
 * @generated from the Resend OpenAPI spec. Do not edit by hand, run `composer generate` instead.
 */
class Automations extends BaseResource
{
    /**
     * Create an automation
     *
     * @param  string  $name  The name of the automation.
     * @param  list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>  $steps  The steps that compose the automation workflow. Must include at least one `trigger` step.
     * @param  list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>  $connections  The connections between steps in the automation graph.
     * @param  'enabled'|'disabled'|null  $status  The initial status of the automation. Defaults to `disabled`.
     */
    public function create(
        string $name,
        array $steps,
        array $connections,
        ?string $status = null,
    ): Response {
        return $this->connector->send(new CreateAutomationRequest(
            $name,
            $steps,
            $connections,
            $status,
        ));
    }

    /**
     * Retrieve a list of automations
     *
     * `$response->dto()` returns a ListResponse<Automation>.
     *
     * @param  'enabled'|'disabled'|null  $status  Filter automations by status.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function list(
        ?string $status = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListAutomationsRequest(
            $status,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single automation
     *
     * `$response->dto()` returns an Automation.
     *
     * @param  string  $automationId  The ID of the automation.
     */
    public function get(string $automationId): Response
    {
        return $this->connector->send(new GetAutomationRequest($automationId));
    }

    /**
     * Update an automation
     *
     * @param  string  $automationId  The ID of the automation.
     * @param  string|null  $name  The name of the automation.
     * @param  'enabled'|'disabled'|null  $status  The status of the automation.
     * @param  list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>|null  $steps  The steps that compose the automation workflow. Must be provided together with `connections`.
     * @param  list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>|null  $connections  The connections between steps in the automation graph. Must be provided together with `steps`.
     */
    public function update(
        string $automationId,
        ?string $name = null,
        ?string $status = null,
        ?array $steps = null,
        ?array $connections = null,
    ): Response {
        return $this->connector->send(new UpdateAutomationRequest(
            $automationId,
            $name,
            $status,
            $steps,
            $connections,
        ));
    }

    /**
     * Delete an automation
     *
     * @param  string  $automationId  The ID of the automation.
     */
    public function remove(string $automationId): Response
    {
        return $this->connector->send(new RemoveAutomationRequest($automationId));
    }

    /**
     * Duplicate an automation
     *
     * @param  string  $automationId  The ID of the automation.
     */
    public function duplicate(string $automationId): Response
    {
        return $this->connector->send(new DuplicateAutomationRequest($automationId));
    }

    /**
     * Stop an automation
     *
     * @param  string  $automationId  The ID of the automation.
     */
    public function stop(string $automationId): Response
    {
        return $this->connector->send(new StopAutomationRequest($automationId));
    }

    /**
     * Retrieve a list of automation runs
     *
     * `$response->dto()` returns a ListResponse<AutomationRun>.
     *
     * @param  string  $automationId  The ID of the automation.
     * @param  string|null  $status  Filter runs by status. Comma-separated list of: running, completed, failed, cancelled.
     * @param  int|null  $limit  Number of items to return.
     * @param  string|null  $after  Return items after this cursor.
     * @param  string|null  $before  Return items before this cursor.
     */
    public function listRuns(
        string $automationId,
        ?string $status = null,
        ?int $limit = null,
        ?string $after = null,
        ?string $before = null,
    ): Response {
        return $this->connector->send(new ListAutomationRunsRequest(
            $automationId,
            $status,
            $limit,
            $after,
            $before,
        ));
    }

    /**
     * Retrieve a single automation run
     *
     * `$response->dto()` returns an AutomationRun.
     *
     * @param  string  $automationId  The ID of the automation.
     * @param  string  $runId  The ID of the automation run.
     */
    public function getRun(string $automationId, string $runId): Response
    {
        return $this->connector->send(new GetAutomationRunRequest($automationId, $runId));
    }
}
