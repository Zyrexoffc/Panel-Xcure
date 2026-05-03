<?php

namespace Xcure\Providers;

use Xcure\Models\User;
use Xcure\Models\Server;
use Xcure\Models\Subuser;
use Xcure\Models\EggVariable;
use Xcure\Observers\UserObserver;
use Xcure\Observers\ServerObserver;
use Xcure\Observers\SubuserObserver;
use Xcure\Listeners\TwoFactorListener;
use Xcure\Listeners\RevocationListener;
use Xcure\Observers\EggVariableObserver;
use Xcure\Listeners\AuthenticationListener;
use Xcure\Events\Server\Installed as ServerInstalledEvent;
use Xcure\Notifications\ServerInstalled as ServerInstalledNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     */
    protected $listen = [
        ServerInstalledEvent::class => [ServerInstalledNotification::class],
    ];

    protected $subscribe = [
        AuthenticationListener::class,
        RevocationListener::class,
        TwoFactorListener::class,
    ];

    protected static $shouldDiscoverEvents = false;

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        User::observe(UserObserver::class);
        Server::observe(ServerObserver::class);
        Subuser::observe(SubuserObserver::class);
        EggVariable::observe(EggVariableObserver::class);
    }
}
