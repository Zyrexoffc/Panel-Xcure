<?php

namespace Xcure\Http\Requests\Api\Application\Locations;

use Xcure\Services\Acl\Api\AdminAcl;
use Xcure\Http\Requests\Api\Application\ApplicationApiRequest;

class DeleteLocationRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_LOCATIONS;

    protected int $permission = AdminAcl::WRITE;
}
