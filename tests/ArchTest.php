<?php

use Saloon\Http\BaseResource;
use Saloon\Http\Request;

arch('requests extend the saloon request')
    ->expect('TobiasNagel01\ResendSdk\Requests')
    ->toExtend(Request::class)
    ->toHaveSuffix('Request');

arch('resources extend the saloon base resource')
    ->expect('TobiasNagel01\ResendSdk\Resources')
    ->toExtend(BaseResource::class);

arch('DTOs are final and readonly')
    ->expect('TobiasNagel01\ResendSdk\Data')
    ->toBeFinal()
    ->toBeReadonly();

arch('no debugging statements')
    ->expect(['dd', 'dump', 'ray', 'var_dump'])
    ->not->toBeUsed();
