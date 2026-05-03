<?php

namespace Xcure\Http\Requests\Api\Application\Servers\Databases;

use Xcure\Services\Acl\Api\AdminAcl;

class ServerDatabaseWriteRequest extends GetServerDatabasesRequest
{
    protected int $permission = AdminAcl::WRITE;
}
