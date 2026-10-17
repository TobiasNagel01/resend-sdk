# Resend::automations()

Automations endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Automations`.

## `create()`

`POST /automations` – Create an automation

```php
Resend::automations()->create(
    string $name,
    array $steps,
    array $connections,
    ?string $status = null,
): Response
```

- `$name` (`string`, required) The name of the automation.
- `$steps` (`list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>`, required) The steps that compose the automation workflow. Must include at least one `trigger` step.
- `$connections` (`list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>`, required) The connections between steps in the automation graph.
- `$status` (`'enabled'|'disabled'|null`) The initial status of the automation. Defaults to `disabled`.

## `list()`

`GET /automations` – Retrieve a list of automations

```php
Resend::automations()->list(
    ?string $status = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `Automation`.

- `$status` (`'enabled'|'disabled'|null`, query `status`) Filter automations by status.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /automations/{automation_id}` – Retrieve a single automation

```php
Resend::automations()->get(string $automationId): Response
```

`$response->dto()` returns an `Automation`.

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.

## `update()`

`PATCH /automations/{automation_id}` – Update an automation

```php
Resend::automations()->update(
    string $automationId,
    ?string $name = null,
    ?string $status = null,
    ?array $steps = null,
    ?array $connections = null,
): Response
```

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.
- `$name` (`string|null`) The name of the automation.
- `$status` (`'enabled'|'disabled'|null`) The status of the automation.
- `$steps` (`list<array{key: string, type: 'trigger'|'send_email'|'delay'|'wait_for_event'|'condition'|'contact_update'|'contact_delete'|'add_to_segment', config: array<string, mixed>}>|null`) The steps that compose the automation workflow. Must be provided together with `connections`.
- `$connections` (`list<array{from: string, to: string, type?: 'default'|'condition_met'|'condition_not_met'|'timeout'|'event_received'}>|null`) The connections between steps in the automation graph. Must be provided together with `steps`.

## `remove()`

`DELETE /automations/{automation_id}` – Delete an automation

```php
Resend::automations()->remove(string $automationId): Response
```

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.

## `duplicate()`

`POST /automations/{automation_id}/duplicate` – Duplicate an automation

```php
Resend::automations()->duplicate(string $automationId): Response
```

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.

## `stop()`

`POST /automations/{automation_id}/stop` – Stop an automation

```php
Resend::automations()->stop(string $automationId): Response
```

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.

## `listRuns()`

`GET /automations/{automation_id}/runs` – Retrieve a list of automation runs

```php
Resend::automations()->listRuns(
    string $automationId,
    ?string $status = null,
    ?int $limit = null,
    ?string $after = null,
    ?string $before = null,
): Response
```

`$response->dto()` returns a `ListResponse` of `AutomationRun`.

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.
- `$status` (`string|null`, query `status`) Filter runs by status. Comma-separated list of: running, completed, failed, cancelled.
- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `getRun()`

`GET /automations/{automation_id}/runs/{run_id}` – Retrieve a single automation run

```php
Resend::automations()->getRun(string $automationId, string $runId): Response
```

`$response->dto()` returns an `AutomationRun`.

- `$automationId` (`string`, required, path `automation_id`) The ID of the automation.
- `$runId` (`string`, required, path `run_id`) The ID of the automation run.
