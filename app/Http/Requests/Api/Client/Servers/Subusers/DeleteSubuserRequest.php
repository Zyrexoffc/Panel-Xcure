<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Subusers;

use Xcure\Models\Permission;

class DeleteSubuserRequest extends SubuserRequest
{
    public function permission(): string
    {
        return Permission::ACTION_USER_DELETE;
    }
}
