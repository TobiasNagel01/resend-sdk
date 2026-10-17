<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Support;

/**
 * Default for optional fields the API accepts as `null`.
 *
 * Leaving the argument at `Omit::Value` keeps the field out of the payload,
 * while passing `null` explicitly sends `null` (e.g. to clear a value).
 */
enum Omit
{
    case Value;
}
