<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Startup;

use Xcure\Models\Permission;
use Xcure\Http\Requests\Api\Client\ClientApiRequest;

class GetStartupRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_STARTUP_READ;
    }
}
