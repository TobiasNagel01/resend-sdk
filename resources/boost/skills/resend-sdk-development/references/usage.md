# Resend::usage()

Usage endpoints of the Resend API. Every method sends the request through the connector and returns a `Saloon\Http\Response`; failed requests throw `TobiasNagel01\ResendSdk\Exceptions\ResendException`. The matching Saloon request classes live in `TobiasNagel01\ResendSdk\Requests\Usage`.

## `get()`

`GET /usage` – Retrieve account usage

Retrieve your account's current usage and plan limits.

```php
Resend::usage()->get(): Response
```
