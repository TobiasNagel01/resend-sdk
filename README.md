# Resend SDK for Laravel

A [Saloon](https://docs.saloon.dev) v4 SDK for the complete [Resend API](https://resend.com/docs/api-reference), with first-class Laravel integration.

- Every endpoint of the [Resend OpenAPI spec](https://github.com/resend/resend-openapi) (142 operations, 18 resources) as typed Saloon requests
- Readonly DTOs for the core objects (emails, domains, contacts, broadcasts, webhooks, inboxes, …)
- Service provider, facade and config, plus `Saloon::fake()` support in your tests
- Generated from the spec by a generator that ships with the package, so it stays in sync with the API

## Requirements

- PHP 8.3+
- Laravel 12.39+ or 13 (optional, the connector also works standalone)

## Installation

```bash
composer require tobiasnagel01/resend-sdk
```

Add your API key to `.env`:

```dotenv
RESEND_API_KEY=re_...
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag=resend-config
```

| Option           | Env                     | Default                  |
|------------------|-------------------------|--------------------------|
| `api_key`        | `RESEND_API_KEY`        | –                        |
| `base_url`       | `RESEND_BASE_URL`       | `https://api.resend.com` |
| `timeout`        | `RESEND_TIMEOUT`        | `30` seconds             |
| `tries`          | `RESEND_TRIES`          | no retries               |
| `retry_interval` | `RESEND_RETRY_INTERVAL` | `1000` ms                |

## Usage

### Laravel

Use the facade or inject the connector, which is registered as a singleton:

```php
use TobiasNagel01\ResendSdk\Facades\Resend;

$response = Resend::emails()->send(
    from: 'Acme <onboarding@resend.dev>',
    to: ['delivered@resend.dev'],
    subject: 'Hello World',
    html: '<strong>It works!</strong>',
    idempotencyKey: 'welcome-user-123',
);

$response->json('id');
```

```php
use TobiasNagel01\ResendSdk\Resend;

class SendWelcomeMail
{
    public function __construct(private Resend $resend) {}

    public function __invoke(User $user): void
    {
        $this->resend->emails()->send('Acme <hi@acme.com>', $user->email, 'Welcome!', text: 'Hi!');
    }
}
```

### Without Laravel

```php
use TobiasNagel01\ResendSdk\Resend;

$resend = new Resend(apiKey: 're_...');

$resend->domains()->create(name: 'example.com', region: 'eu-west-1');
```

### Responses and DTOs

Every resource method returns a `Saloon\Http\Response`. Endpoints that return a core object map it to a DTO through `$response->dto()`; list endpoints return a `ListResponse` that you can iterate:

```php
$emails = Resend::emails()->list(limit: 50)->dto(); // ListResponse<Email>

foreach ($emails as $email) {
    echo $email->id, ' ', $email->lastEvent;
}

if ($emails->hasMore) {
    $next = Resend::emails()->list(limit: 50, after: $emails->nextCursor())->dto();
}

$domain = Resend::domains()->get('d91cd9bd-1176-453e-8fc1-35364d380206')->dto(); // Domain

$domain->records[0]->value; // DomainRecord
```

For every other endpoint use `$response->json()`, `$response->collect()` or `$response->object()`.

### Available resources

| Accessor              | Methods |
|-----------------------|---------|
| `apiKeys()`           | `create`, `list`, `update`, `remove` |
| `audiences()`         | `create`, `list`, `remove`, `get` (deprecated, use segments) |
| `automations()`       | `create`, `list`, `get`, `update`, `remove`, `duplicate`, `stop`, `listRuns`, `getRun` |
| `broadcasts()`        | `create`, `list`, `remove`, `get`, `update`, `send`, `cancel`, `duplicate`, `listRecipients`, `listClickedLinks` |
| `contactProperties()` | `create`, `list`, `get`, `update`, `remove` |
| `contacts()`          | `create`, `list`, `createImport`, `listImports`, `getImport`, `get`, `update`, `remove`, `listSegments`, `addSegment`, `removeSegment`, `listTopics`, `updateTopics` |
| `domains()`           | `create`, `list`, `get`, `update`, `remove`, `verify`, `createClaim`, `getClaim`, `verifyClaim` |
| `emails()`            | `send`, `list`, `get`, `update`, `cancel`, `share`, `sendBatch`, `listAttachments`, `getAttachment`, `listReceiving`, `getReceiving`, `listReceivingAttachments`, `getReceivingAttachment`, `metrics` |
| `events()`            | `create`, `list`, `send`, `get`, `update`, `remove` |
| `inboxes()`           | `create`, `list`, `get`, `update`, `remove`, `getAgent`, `updateAgent`, `listLabels`, `createLabel`, `updateLabel`, `removeLabel`, `listThreads`, `searchThreads`, `getThread`, `updateThread`, `removeThread`, `addThreadLabels`, `setThreadLabels`, `removeThreadLabel`, `listThreadEmails`, `getThreadEmail`, `replyThreadEmail`, `forwardThreadEmail`, `listDrafts`, `createDraft`, `getDraft`, `updateDraft`, `removeDraft`, `sendDraft` |
| `logs()`              | `list`, `get` |
| `oauth()`             | `listGrants`, `revokeGrant` |
| `segments()`          | `create`, `list`, `get`, `update`, `remove`, `listContacts` |
| `suppressions()`      | `add`, `list`, `batchAdd`, `batchRemove`, `get`, `remove` |
| `templates()`         | `create`, `list`, `get`, `update`, `remove`, `publish`, `duplicate` |
| `topics()`            | `create`, `list`, `get`, `update`, `remove` |
| `usage()`             | `get` |
| `webhooks()`          | `create`, `list`, `get`, `update`, `remove`, `rotateSigningSecret`, `listEvents`, `getEvent`, `replayEvent`, `listEventAttempts` |

Arguments are named after the API fields in camelCase (`reply_to` → `replyTo`). Two arguments are renamed because they clash with Saloon: the email `headers` field is `customHeaders`, and the thread search `query` is `searchQuery`.

### More examples

```php
// Batch sending
Resend::emails()->sendBatch([
    ['from' => 'hi@acme.com', 'to' => 'a@example.com', 'subject' => 'One', 'html' => '<p>1</p>'],
    ['from' => 'hi@acme.com', 'to' => 'b@example.com', 'subject' => 'Two', 'html' => '<p>2</p>'],
]);

// Contact import (multipart upload); JSON fields accept arrays
Resend::contacts()->createImport(
    file: fopen(storage_path('contacts.csv'), 'r'),
    columnMap: ['email' => 'Email', 'first_name' => 'First Name'],
    onConflict: 'upsert',
);

// Metrics: array query parameters are sent comma-separated
Resend::emails()->metrics(metrics: ['delivered', 'opened'], dimensions: ['period'], granularity: 'daily');
```

Some PATCH fields can be cleared with an explicit `null` (e.g. the inbox agent's `instructions`). Those arguments default to `Omit::Value`, so leaving them out never sends `null` by accident:

```php
Resend::inboxes()->updateAgent('support@acme.com', instructions: null); // sends {"instructions": null}
```

### Using request classes directly

Each operation is a Saloon request under `TobiasNagel01\ResendSdk\Requests\{Resource}`. Use them when you need to change a request before sending it:

```php
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;

$request = new SendEmailRequest('hi@acme.com', 'user@example.com', 'Hi', text: 'Hi');
$request->body()->add('some_new_field', true);

$response = app(Resend::class)->send($request);
```

### Error handling

Failed responses throw `TobiasNagel01\ResendSdk\Exceptions\ResendException` (a Saloon `RequestException`):

```php
use TobiasNagel01\ResendSdk\Exceptions\ResendException;

try {
    Resend::emails()->send(/* ... */);
} catch (ResendException $e) {
    $e->statusCode();   // 422
    $e->errorName;      // "validation_error"
    $e->errorMessage;   // "The `to` field must be a valid email."
    $e->getResponse();  // Saloon\Http\Response
}
```

## Testing your application

The [Saloon Laravel plugin](https://docs.saloon.dev/installable-plugins/laravel-integration) is included, so you can fake responses:

```php
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;

Saloon::fake([
    SendEmailRequest::class => MockResponse::make(['id' => '49a3999c-0ce1-4ea6-ab68-afcd6dc2e794']),
]);

// ... run your code

Saloon::assertSent(SendEmailRequest::class);
```

## Development

```bash
composer test       # Pest test suite (includes a generated test for every endpoint)
composer format     # Laravel Pint
composer generate   # regenerate requests, resources, DTOs and endpoint tests from resources/openapi/resend.yaml
php tools/generate.php --fetch   # download the latest spec first, then regenerate
```

Generated files carry an `@generated` marker and are never edited by hand. Naming, DTO definitions and fixes for spec gaps (e.g. the missing request body of `PATCH /emails/{email_id}`) live in `tools/overrides.php`. The hand-written code is the connector (`src/Resend.php`), `src/Support`, `src/Exceptions`, `src/Data/ListResponse.php` and the Laravel integration.

## License

MIT, see [LICENSE.md](LICENSE.md).
