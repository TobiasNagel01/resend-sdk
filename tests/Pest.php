<?php

use Saloon\Http\Faking\MockClient;
use TobiasNagel01\ResendSdk\Resend;
use TobiasNagel01\ResendSdk\Tests\TestCase;

pest()->extend(TestCase::class)->in('Laravel');

/**
 * A connector whose requests are answered by the given mock client.
 */
function resend(MockClient $mockClient): Resend
{
    return (new Resend('re_test_key'))->withMockClient($mockClient);
}
