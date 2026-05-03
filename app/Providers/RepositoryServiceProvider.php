<?php

namespace Xcure\Providers;

use Illuminate\Support\ServiceProvider;
use Xcure\Repositories\Eloquent\EggRepository;
use Xcure\Repositories\Eloquent\NestRepository;
use Xcure\Repositories\Eloquent\NodeRepository;
use Xcure\Repositories\Eloquent\TaskRepository;
use Xcure\Repositories\Eloquent\UserRepository;
use Xcure\Repositories\Eloquent\ApiKeyRepository;
use Xcure\Repositories\Eloquent\ServerRepository;
use Xcure\Repositories\Eloquent\SessionRepository;
use Xcure\Repositories\Eloquent\SubuserRepository;
use Xcure\Repositories\Eloquent\DatabaseRepository;
use Xcure\Repositories\Eloquent\LocationRepository;
use Xcure\Repositories\Eloquent\ScheduleRepository;
use Xcure\Repositories\Eloquent\SettingsRepository;
use Xcure\Repositories\Eloquent\AllocationRepository;
use Xcure\Contracts\Repository\EggRepositoryInterface;
use Xcure\Repositories\Eloquent\EggVariableRepository;
use Xcure\Contracts\Repository\NestRepositoryInterface;
use Xcure\Contracts\Repository\NodeRepositoryInterface;
use Xcure\Contracts\Repository\TaskRepositoryInterface;
use Xcure\Contracts\Repository\UserRepositoryInterface;
use Xcure\Repositories\Eloquent\DatabaseHostRepository;
use Xcure\Contracts\Repository\ApiKeyRepositoryInterface;
use Xcure\Contracts\Repository\ServerRepositoryInterface;
use Xcure\Repositories\Eloquent\ServerVariableRepository;
use Xcure\Contracts\Repository\SessionRepositoryInterface;
use Xcure\Contracts\Repository\SubuserRepositoryInterface;
use Xcure\Contracts\Repository\DatabaseRepositoryInterface;
use Xcure\Contracts\Repository\LocationRepositoryInterface;
use Xcure\Contracts\Repository\ScheduleRepositoryInterface;
use Xcure\Contracts\Repository\SettingsRepositoryInterface;
use Xcure\Contracts\Repository\AllocationRepositoryInterface;
use Xcure\Contracts\Repository\EggVariableRepositoryInterface;
use Xcure\Contracts\Repository\DatabaseHostRepositoryInterface;
use Xcure\Contracts\Repository\ServerVariableRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register all the repository bindings.
     */
    public function register(): void
    {
        // Eloquent Repositories
        $this->app->bind(AllocationRepositoryInterface::class, AllocationRepository::class);
        $this->app->bind(ApiKeyRepositoryInterface::class, ApiKeyRepository::class);
        $this->app->bind(DatabaseRepositoryInterface::class, DatabaseRepository::class);
        $this->app->bind(DatabaseHostRepositoryInterface::class, DatabaseHostRepository::class);
        $this->app->bind(EggRepositoryInterface::class, EggRepository::class);
        $this->app->bind(EggVariableRepositoryInterface::class, EggVariableRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(NestRepositoryInterface::class, NestRepository::class);
        $this->app->bind(NodeRepositoryInterface::class, NodeRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(ServerRepositoryInterface::class, ServerRepository::class);
        $this->app->bind(ServerVariableRepositoryInterface::class, ServerVariableRepository::class);
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);
        $this->app->bind(SubuserRepositoryInterface::class, SubuserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
