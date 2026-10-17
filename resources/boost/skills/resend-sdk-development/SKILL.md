---
name: resend-sdk-development
description: "Use when calling the Resend API from a Laravel app through the tobiasnagel01/resend-sdk package. Trigger whenever code uses the TobiasNagel01\\ResendSdk namespace, the Resend facade or connector, or RESEND_API_KEY, or when the task involves sending single, batch or scheduled emails via the Resend API, managing domains, contacts, contact imports, segments, topics, broadcasts, templates, webhooks, inboxes, automations, events, suppressions or API keys, reading email metrics, or faking Resend API calls in Pest or PHPUnit tests. Do not trigger for Laravel's Mail facade or Mailables sent through the resend mail transport, or for other mail providers."
license: MIT
metadata:
  author: tobiasnagel01
---
# Resend SDK

`tobiasnagel01/resend-sdk` is a Saloon v4 SDK for the complete Resend API. Every endpoint is a method on a resource of the `TobiasNagel01\ResendSdk\Resend` connector, e.g. `Resend::emails()->send(...)`.

## When to use this skill

Use it when code talks to the Resend API directly: sending emails with Resend-specific options (scheduling, idempotency keys, templates, tags, topics), batch sending, or managing any other Resend object. Laravel Mailables sent with `Mail::to(...)->send(...)` over the `resend` mail transport do not use this package.

## Setup

The package registers its service provider and the `Resend` facade automatically. Only the API key is required:

```dotenv
RESEND_API_KEY=re_...
```

Optional settings (publish with `php artisan vendor:publish --tag=resend-config` to change them in `config/resend.php`):

| Config key | Env | Default |
|---|---|---|
| `resend.base_url` | `RESEND_BASE_URL` | `https://api.resend.com` |
| `resend.timeout` | `RESEND_TIMEOUT` | `30` seconds |
| `resend.tries` | `RESEND_TRIES` | no retries |
| `resend.retry_interval` | `RESEND_RETRY_INTERVAL` | `1000` ms |

## Calling the API

Use the facade, or inject the connector (bound as a singleton):

```php
use TobiasNagel01\ResendSdk\Facades\Resend;

$response = Resend::emails()->send(
    from: 'Acme <hello@acme.com>',
    to: $user->email,
    subject: 'Welcome!',
    html: view('emails.welcome', ['user' => $user])->render(),
    idempotencyKey: "welcome-{$user->id}",
);

$emailId = $response->json('id');
```

```php
use TobiasNagel01\ResendSdk\Resend;

class SyncContact
{
    public function __construct(private Resend $resend) {}

    public function handle(User $user): void
    {
        $this->resend->contacts()->create(email: $user->email, firstName: $user->first_name);
    }
}
```

Outside the container: `new Resend(apiKey: 're_...', timeout: 10, tries: 3)`.

### Resources

Each accessor has a reference file listing every method with its signature, HTTP endpoint, arguments and DTO. Read the matching file before calling a method you have not used yet.

| Accessor | Reference |
|---|---|
| `apiKeys()` | `references/api-keys.md` |
| `audiences()` (deprecated, use `segments()`) | `references/audiences.md` |
| `automations()` | `references/automations.md` |
| `broadcasts()` | `references/broadcasts.md` |
| `contactProperties()` | `references/contact-properties.md` |
| `contacts()` | `references/contacts.md` |
| `domains()` | `references/domains.md` |
| `emails()` | `references/emails.md` |
| `events()` | `references/events.md` |
| `inboxes()` | `references/inboxes.md` |
| `logs()` | `references/logs.md` |
| `oauth()` | `references/oauth.md` |
| `segments()` | `references/segments.md` |
| `suppressions()` | `references/suppressions.md` |
| `templates()` | `references/templates.md` |
| `topics()` | `references/topics.md` |
| `usage()` | `references/usage.md` |
| `webhooks()` | `references/webhooks.md` |

DTO properties are listed in `references/data.md`.

## Arguments

- Pass the required arguments first, then use named arguments for everything else. The order of optional arguments is not meant to be stable.
- Arguments are the API fields in camelCase: `reply_to` → `replyTo`, `scheduled_at` → `scheduledAt`, path parameters like `email_id` → `emailId`.
- Two names differ from the API: the email `headers` field is `customHeaders`, and the inbox thread search `query` is `searchQuery`.
- Endpoints that support the `Idempotency-Key` header take an `idempotencyKey` argument.
- Pass path parameters as plain values (`'support@acme.com'`); they are URL-encoded for you.
- Optional arguments default to `null` and are left out of the request. Some PATCH fields can be cleared with an explicit `null`; those default to `TobiasNagel01\ResendSdk\Support\Omit::Value` instead, so omitting them never clears anything:

```php
Resend::inboxes()->updateAgent('support@acme.com', tone: 'friendly'); // instructions untouched
Resend::inboxes()->updateAgent('support@acme.com', instructions: null); // sends {"instructions": null}
```

- Array query parameters take PHP arrays; they are sent comma-separated:

```php
Resend::emails()->metrics(metrics: ['delivered', 'opened'], dimensions: ['period'], granularity: 'daily');
```

- `sendBatch()` takes up to 100 raw email payloads with the API's snake_case keys:

```php
Resend::emails()->sendBatch([
    ['from' => 'hi@acme.com', 'to' => 'a@example.com', 'subject' => 'One', 'html' => '<p>1</p>'],
    ['from' => 'hi@acme.com', 'to' => ['b@example.com'], 'subject' => 'Two', 'reply_to' => 'support@acme.com', 'text' => '2'],
], idempotencyKey: 'digest-2026-10-17');
```

- `contacts()->createImport()` uploads a CSV as multipart. Pass a stream resource, a PSR-7 stream or the file contents; `columnMap`, `segments` and `topics` accept PHP arrays and are JSON-encoded for you:

```php
Resend::contacts()->createImport(
    file: fopen(storage_path('app/contacts.csv'), 'r'),
    columnMap: ['email' => 'Email', 'first_name' => 'First Name'],
    onConflict: 'upsert',
);
```

## Responses and DTOs

Every resource method returns a `Saloon\Http\Response`. Read raw data with `->json()`, `->json('id')`, `->collect('data')` or `->object()`.

Endpoints that return a core object map it with `->dto()`; the reference files say which DTO an endpoint returns. Endpoints without a DTO (creates, deletes, most actions) must be read with `->json()`.

```php
use TobiasNagel01\ResendSdk\Data\Domain;

/** @var Domain $domain */
$domain = Resend::domains()->get($domainId)->dto();

$domain->status;           // 'verified'
$domain->records[0]->value; // DomainRecord
```

List endpoints return a `TobiasNagel01\ResendSdk\Data\ListResponse`: iterate it, `count()` it, or read `data` and `hasMore`. Use `nextCursor()` with `after` to page through the results:

```php
$after = null;

do {
    $page = Resend::contacts()->list(limit: 100, after: $after)->dto();

    foreach ($page as $contact) {
        // $contact is a TobiasNagel01\ResendSdk\Data\Contact
    }

    $after = $page->nextCursor();
} while ($after !== null);
```

DTO properties are camelCase and nullable (`$email->lastEvent`, `$email->createdAt`).

## Errors

Every 4xx/5xx response throws `TobiasNagel01\ResendSdk\Exceptions\ResendException`, a Saloon `RequestException`:

```php
use TobiasNagel01\ResendSdk\Exceptions\ResendException;

try {
    Resend::emails()->send(from: 'hi@acme.com', to: $address, subject: 'Hi', text: 'Hi');
} catch (ResendException $e) {
    $e->statusCode();  // 422
    $e->errorName;     // 'validation_error'
    $e->errorMessage;  // 'The `to` field must be a valid email.'
    $e->getResponse(); // Saloon\Http\Response
}
```

Set `RESEND_TRIES` (and `RESEND_RETRY_INTERVAL`) to retry failed requests, e.g. on `429` rate limits.

## Request classes

Every method has a matching Saloon request, named `TobiasNagel01\ResendSdk\Requests\{Resource}\{Name}Request` (`emails()->send()` → `Requests\Emails\SendEmailRequest`, `contacts()->list()` → `Requests\Contacts\ListContactsRequest`). Its constructor takes the same arguments as the resource method. Use it directly to change a request before sending, or to reference it in fakes:

```php
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;
use TobiasNagel01\ResendSdk\Resend;

$request = new SendEmailRequest('hi@acme.com', 'user@example.com', 'Hi', text: 'Hi');

$response = app(Resend::class)->send($request);
```

## Testing

Never hit the real API in tests. The Saloon Laravel plugin is installed with the package, so fake responses per request class:

```php
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use TobiasNagel01\ResendSdk\Requests\Emails\SendEmailRequest;

it('sends the welcome email', function () {
    Saloon::fake([
        SendEmailRequest::class => MockResponse::make(['id' => '49a3999c-0ce1-4ea6-ab68-afcd6dc2e794']),
    ]);

    // ... run the code under test

    Saloon::assertSent(fn (SendEmailRequest $request) => $request->body()->get('to') === 'user@example.com');
});
```

Fake failures with `MockResponse::make(['name' => 'validation_error', 'message' => '...'], 422)`; the code under test then receives a `ResendException`. For `->dto()` to work in a fake, return the same JSON shape as the API (`['object' => 'list', 'has_more' => false, 'data' => [...]]` for lists).

## Common pitfalls

- Passing optional arguments positionally. Use named arguments after the required ones.
- Using the API's snake_case names as named arguments (`reply_to:`), except inside `sendBatch()` payloads, which are raw API arrays.
- Calling `->dto()` on an endpoint the reference does not list a DTO for.
- Building new code on `audiences()`; it is deprecated in favour of `segments()`.
- Catching `Illuminate\Http\Client\RequestException`. The SDK uses Saloon, not Laravel's HTTP client; catch `ResendException`.
- Using `Http::fake()`. It does not intercept Saloon requests; use `Saloon::fake()`.
