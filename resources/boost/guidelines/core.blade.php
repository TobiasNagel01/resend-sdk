## Resend SDK (tobiasnagel01/resend-sdk)

This application talks to the Resend API through `tobiasnagel01/resend-sdk`, a Saloon SDK that covers every Resend endpoint (emails, domains, contacts, segments, broadcasts, templates, webhooks, inboxes, …).

- Call the Resend API only through the `TobiasNagel01\ResendSdk\Facades\Resend` facade or the injected `TobiasNagel01\ResendSdk\Resend` connector, never with `Http::` or another HTTP client. The API key comes from `RESEND_API_KEY`.
- Endpoints are methods on resources: `Resend::emails()->send(...)`, `Resend::contacts()->list(...)`, `Resend::domains()->verify($id)`.
- Pass the required arguments first, then named arguments in camelCase (`replyTo:`, `scheduledAt:`, `idempotencyKey:`).
- Methods return a `Saloon\Http\Response`. Use `->dto()` for endpoints that map to a DTO in `TobiasNagel01\ResendSdk\Data` (lists return a `ListResponse` with `hasMore` and `nextCursor()`), otherwise `->json()`.
- Failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException` (`statusCode()`, `errorName`, `errorMessage`).
- In tests, fake requests with `Saloon::fake([...])` and the request classes in `TobiasNagel01\ResendSdk\Requests\*`; `Http::fake()` does not intercept them.

@verbatim
<code-snippet name="Send an email with the Resend SDK" lang="php">
use TobiasNagel01\ResendSdk\Facades\Resend;

$id = Resend::emails()->send(
    from: 'Acme <hello@acme.com>',
    to: $user->email,
    subject: 'Welcome!',
    html: view('emails.welcome', ['user' => $user])->render(),
    idempotencyKey: "welcome-{$user->id}",
)->json('id');
</code-snippet>
@endverbatim

For method signatures, pagination, batch sending, contact imports and testing, activate the `resend-sdk-development` skill.
