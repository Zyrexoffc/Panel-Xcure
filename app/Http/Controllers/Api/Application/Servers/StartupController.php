<?php

namespace Xcure\Http\Controllers\Api\Application\Servers;

use Xcure\Models\User;
use Xcure\Models\Server;
use Xcure\Services\Servers\StartupModificationService;
use Xcure\Transformers\Api\Application\ServerTransformer;
use Xcure\Http\Controllers\Api\Application\ApplicationApiController;
use Xcure\Http\Requests\Api\Application\Servers\UpdateServerStartupRequest;

class StartupController extends ApplicationApiController
{
    /**
     * StartupController constructor.
     */
    public function __construct(private StartupModificationService $modificationService)
    {
        parent::__construct();
    }

    /**
     * Update the startup and environment settings for a specific server.
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Xcure\Exceptions\Http\Connection\DaemonConnectionException
     * @throws \Xcure\Exceptions\Model\DataValidationException
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     */
    public function index(UpdateServerStartupRequest $request, Server $server): array
    {
        $server = $this->modificationService
            ->setUserLevel(User::USER_LEVEL_ADMIN)
            ->handle($server, $request->validated());

        return $this->fractal->item($server)
            ->transformWith($this->getTransformer(ServerTransformer::class))
            ->toArray();
    }
}
