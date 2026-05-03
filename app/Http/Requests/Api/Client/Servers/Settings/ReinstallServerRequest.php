<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Settings;

use Xcure\Models\Permission;
use Xcure\Http\Requests\Api\Client\ClientApiRequest;

class ReinstallServerRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_SETTINGS_REINSTALL;
    }
}
