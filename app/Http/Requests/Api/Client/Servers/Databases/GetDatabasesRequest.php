<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Databases;

use Xcure\Models\Permission;
use Xcure\Contracts\Http\ClientPermissionsRequest;
use Xcure\Http\Requests\Api\Client\ClientApiRequest;

class GetDatabasesRequest extends ClientApiRequest implements ClientPermissionsRequest
{
    public function permission(): string
    {
        return Permission::ACTION_DATABASE_READ;
    }
}
