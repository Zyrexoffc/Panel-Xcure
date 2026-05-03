<?php

namespace Xcure\Http\Requests\Api\Client\Servers\Files;

use Xcure\Models\Permission;
use Xcure\Http\Requests\Api\Client\ClientApiRequest;

class UploadFileRequest extends ClientApiRequest
{
    public function permission(): string
    {
        return Permission::ACTION_FILE_CREATE;
    }
}
