<?php

namespace Xcure\Http\Requests\Api\Application\Servers;

use Xcure\Services\Acl\Api\AdminAcl;
use Xcure\Http\Requests\Api\Application\ApplicationApiRequest;

class GetServerRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_SERVERS;

    protected int $permission = AdminAcl::READ;
}
