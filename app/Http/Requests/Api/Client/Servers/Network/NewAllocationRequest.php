<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Network;

use Xcure\Models\Permission;
use Xcure\Http\Requests\Api\Client\ClientApiRequest;

class NewAllocationRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_ALLOCATION_CREATE;
    }
}
