<?php

namespace Xcure\Facades;

use Illuminate\Support\Facades\Facade;
use Xcure\Services\Activity\ActivityLogBatchService;

class LogBatch extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogBatchService::class;
    }
}
