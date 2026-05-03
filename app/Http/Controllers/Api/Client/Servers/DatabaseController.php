<?php

namespace Xcure\Http\Controllers\Api\Client\Servers;

use Illuminate\Http\Response;
use Xcure\Models\Server;
use Xcure\Models\Database;
use Xcure\Facades\Activity;
use Xcure\Services\Databases\DatabasePasswordService;
use Xcure\Transformers\Api\Client\DatabaseTransformer;
use Xcure\Services\Databases\DatabaseManagementService;
use Xcure\Services\Databases\DeployServerDatabaseService;
use Xcure\Http\Controllers\Api\Client\ClientApiController;
use Xcure\Http\Requests\Api\Client\Servers\Databases\GetDatabasesRequest;
use Xcure\Http\Requests\Api\Client\Servers\Databases\StoreDatabaseRequest;
use Xcure\Http\Requests\Api\Client\Servers\Databases\DeleteDatabaseRequest;
use Xcure\Http\Requests\Api\Client\Servers\Databases\RotatePasswordRequest;

class DatabaseController extends ClientApiController
{
    /**
     * DatabaseController constructor.
     */
    public function __construct(
        private DeployServerDatabaseService $deployDatabaseService,
        private DatabaseManagementService $managementService,
        private DatabasePasswordService $passwordService,
    ) {
        parent::__construct();
    }

    /**
     * Return all the databases that belong to the given server.
     */
    public function index(GetDatabasesRequest $request, Server $server): array
    {
        return $this->fractal->collection($server->databases)
            ->transformWith($this->getTransformer(DatabaseTransformer::class))
            ->toArray();
    }

    /**
     * Create a new database for the given server and return it.
     *
     * @throws \Throwable
     * @throws \Xcure\Exceptions\Service\Database\TooManyDatabasesException
     * @throws \Xcure\Exceptions\Service\Database\DatabaseClientFeatureNotEnabledException
     */
    public function store(StoreDatabaseRequest $request, Server $server): array
    {
        $database = Activity::event('server:database.create')->transaction(function ($log) use ($request, $server) {
            $server->databases()->lockForUpdate();

            $database = $this->deployDatabaseService->handle($server, $request->validated());

            $log->subject($database)->property('name', $database->database);

            return $database;
        });

        return $this->fractal->item($database)
            ->parseIncludes(['password'])
            ->transformWith($this->getTransformer(DatabaseTransformer::class))
            ->toArray();
    }

    /**
     * Rotates the password for the given server model and returns a fresh instance to
     * the caller.
     *
     * @throws \Throwable
     */
    public function rotatePassword(RotatePasswordRequest $request, Server $server, Database $database): array
    {
        Activity::event('server:database.rotate-password')
            ->subject($database)
            ->property('name', $database->database)
            ->transaction(function () use ($database) {
                $database->lockForUpdate();

                $this->passwordService->handle($database);
            });

        return $this->fractal->item($database->refresh())
            ->parseIncludes(['password'])
            ->transformWith($this->getTransformer(DatabaseTransformer::class))
            ->toArray();
    }

    /**
     * Removes a database from the server.
     *
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     */
    public function delete(DeleteDatabaseRequest $request, Server $server, Database $database): Response
    {
        $this->managementService->delete($database);

        Activity::event('server:database.delete')
            ->subject($database)
            ->property('name', $database->database)
            ->log();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
