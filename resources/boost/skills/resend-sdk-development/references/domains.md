# Resend::domains()

Domains endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Domains`.

## `create()`

`POST /domains` – Create a new domain

```php
Resend::domains()->create(
    string $name,
    ?string $region = null,
    ?string $customReturnPath = null,
    ?bool $openTracking = null,
    ?bool $clickTracking = null,
    ?string $tls = null,
    ?array $capabilities = null,
    ?string $trackingSubdomain = null,
): Response
```

- `$name` (`string`, required) The name of the domain you want to create.
- `$region` (`'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null`) The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
- `$customReturnPath` (`string|null`, field `custom_return_path`) For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
- `$openTracking` (`bool|null`, field `open_tracking`) Track the open rate of each email.
- `$clickTracking` (`bool|null`, field `click_tracking`) Track clicks within the body of each HTML email.
- `$tls` (`'opportunistic'|'enforced'|null`) TLS mode. Opportunistic attempts secure connection but falls back to unencrypted. Enforced requires TLS or email won't be sent.
- `$capabilities` (`array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null`) Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
- `$trackingSubdomain` (`string|null`, field `tracking_subdomain`) The subdomain to use for click and open tracking.

## `list()`

`GET /domains` – Retrieve a list of domains

```php
Resend::domains()->list(?int $limit = null, ?string $after = null, ?string $before = null): Response
```

`$response->dto()` returns a `ListResponse` of `Domain`.

- `$limit` (`int|null`, query `limit`) Number of items to return.
- `$after` (`string|null`, query `after`) Return items after this cursor.
- `$before` (`string|null`, query `before`) Return items before this cursor.

## `get()`

`GET /domains/{domain_id}` – Retrieve a single domain

```php
Resend::domains()->get(string $domainId): Response
```

`$response->dto()` returns a `Domain`.

- `$domainId` (`string`, required, path `domain_id`) The ID of the domain.

## `update()`

`PATCH /domains/{domain_id}` – Update an existing domain

```php
Resend::domains()->update(
    string $domainId,
    ?bool $openTracking = null,
    ?bool $clickTracking = null,
    ?string $tls = null,
    ?array $capabilities = null,
    ?string $trackingSubdomain = null,
): Response
```

- `$domainId` (`string`, required, path `domain_id`) The ID of the domain.
- `$openTracking` (`bool|null`, field `open_tracking`) Track the open rate of each email.
- `$clickTracking` (`bool|null`, field `click_tracking`) Track clicks within the body of each HTML email.
- `$tls` (`'opportunistic'|'enforced'|null`) enforced | opportunistic.
- `$capabilities` (`array{sending?: 'enabled'|'disabled', receiving?: 'enabled'|'disabled'}|null`) Configure the domain capabilities for sending and receiving emails. At least one capability must be enabled.
- `$trackingSubdomain` (`string|null`, field `tracking_subdomain`) The subdomain to use for click and open tracking.

## `remove()`

`DELETE /domains/{domain_id}` – Remove an existing domain

```php
Resend::domains()->remove(string $domainId): Response
```

- `$domainId` (`string`, required, path `domain_id`) The ID of the domain.

## `verify()`

`POST /domains/{domain_id}/verify` – Verify an existing domain

Triggers verification of the domain's DNS records including DKIM, SPF, and the tracking CNAME (if a tracking subdomain is configured).

```php
Resend::domains()->verify(string $domainId): Response
```

- `$domainId` (`string`, required, path `domain_id`) The ID of the domain.

## `createClaim()`

`POST /domains/claim` – Claim a domain

Start a claim for a domain that another Resend account has already verified. The domain is recreated under your account with fresh DKIM keys, so the previous account's DNS records cannot be reused. Returns a TXT record to add to your DNS to prove ownership. Uses the same request body as creating a domain.

```php
Resend::domains()->createClaim(
    string $name,
    ?string $region = null,
    ?string $customReturnPath = null,
    ?bool $openTracking = null,
    ?bool $clickTracking = null,
    ?string $trackingSubdomain = null,
): Response
```

`$response->dto()` returns a `DomainClaim`.

- `$name` (`string`, required) The name of the domain you want to claim.
- `$region` (`'us-east-1'|'eu-west-1'|'sa-east-1'|'ap-northeast-1'|null`) The region where emails will be sent from. Possible values are us-east-1 | eu-west-1 | sa-east-1 | ap-northeast-1
- `$customReturnPath` (`string|null`, field `custom_return_path`) For advanced use cases, choose a subdomain for the Return-Path address. Defaults to 'send' (i.e., send.yourdomain.tld).
- `$openTracking` (`bool|null`, field `open_tracking`) Track the open rate of each email.
- `$clickTracking` (`bool|null`, field `click_tracking`) Track clicks within the body of each HTML email.
- `$trackingSubdomain` (`string|null`, field `tracking_subdomain`) The subdomain to use for click and open tracking.

## `getClaim()`

`GET /domains/{domain_id}/claim` – Retrieve a domain claim

Retrieve the latest claim for the placeholder domain created by the claim.

```php
Resend::domains()->getClaim(string $domainId): Response
```

`$response->dto()` returns a `DomainClaim`.

- `$domainId` (`string`, required, path `domain_id`) The ID of the placeholder domain created by the claim.

## `verifyClaim()`

`POST /domains/{domain_id}/claim/verify` – Verify a domain claim

Trigger asynchronous DNS verification and ownership transfer for a domain claim. The claim stays `pending` while verification runs; poll the retrieve endpoint for status. Once `completed`, the transferred domain has new DKIM records that must be added to DNS and verified via the standard domain verify endpoint.

```php
Resend::domains()->verifyClaim(string $domainId): Response
```

`$response->dto()` returns a `DomainClaim`.

- `$domainId` (`string`, required, path `domain_id`) The ID of the placeholder domain created by the claim.
