<?php

namespace Xcure\Http\Requests\Api\Application\Servers\Databases;

use Xcure\Services\Acl\Api\AdminAcl;
use Xcure\Http\Requests\Api\Application\ApplicationApiRequest;

class GetServerDatabasesRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_SERVER_DATABASES;

    protected int $permission = AdminAcl::READ;
}
