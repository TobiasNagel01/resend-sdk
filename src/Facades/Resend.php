<?php

declare(strict_types=1);

namespace TobiasNagel01\ResendSdk\Facades;

use Illuminate\Support\Facades\Facade;
use TobiasNagel01\ResendSdk\Resend as ResendConnector;

/**
 * @mixin ResendConnector
 *
 * @see ResendConnector
 */
class Resend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ResendConnector::class;
    }
}
