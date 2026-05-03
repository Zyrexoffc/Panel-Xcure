<?php

namespace Xcure\Http\Requests\Api\Application\Nodes;

use Xcure\Services\Acl\Api\AdminAcl;
use Xcure\Http\Requests\Api\Application\ApplicationApiRequest;

class DeleteNodeRequest extends ApplicationApiRequest
{
    protected ?string $resource = AdminAcl::RESOURCE_NODES;

    protected int $permission = AdminAcl::WRITE;
}
