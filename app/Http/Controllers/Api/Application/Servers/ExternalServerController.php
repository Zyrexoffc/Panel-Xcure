<?php

namespace Xcure\Http\Controllers\Api\Application\Servers;

use Xcure\Models\Server;
use Xcure\Transformers\Api\Application\ServerTransformer;
use Xcure\Http\Controllers\Api\Application\ApplicationApiController;
use Xcure\Http\Requests\Api\Application\Servers\GetExternalServerRequest;

class ExternalServerController extends ApplicationApiController
{
    /**
     * Retrieve a specific server from the database using its external ID.
     */
    public function index(GetExternalServerRequest $request, string $external_id): array
    {
        $server = Server::query()->where('external_id', $external_id)->firstOrFail();

        return $this->fractal->item($server)
            ->transformWith($this->getTransformer(ServerTransformer::class))
            ->toArray();
    }
}
