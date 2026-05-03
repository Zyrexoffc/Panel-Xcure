<?php

namespace Xcure\Facades;

use Illuminate\Support\Facades\Facade;
use Xcure\Services\Activity\ActivityLogTargetableService;

/**
 * @mixin \Xcure\Services\Activity\ActivityLogTargetableService
 */
class LogTarget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogTargetableService::class;
    }
}
