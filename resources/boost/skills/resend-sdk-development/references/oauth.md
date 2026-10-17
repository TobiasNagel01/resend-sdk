# Resend::oauth()

OAuth endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\OAuth`.

## `listGrants()`

`GET /oauth/grants` – Retrieve a list of OAuth grants

```php
Resend::oauth()->listGrants(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `OAuthGrant`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `revokeGrant()`

`DELETE /oauth/grants/{oauth_grant_id}` – Revoke an OAuth grant

```php
Resend::oauth()->revokeGrant(string $oauthGrantId): Response
```

- `$oauthGrantId` (`string`, required, path `oauth_grant_id`) The OAuth grant ID.
