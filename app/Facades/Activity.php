<?php

namespace Xcure\Facades;

use Illuminate\Support\Facades\Facade;
use Xcure\Services\Activity\ActivityLogService;

class Activity extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogService::class;
    }
}
