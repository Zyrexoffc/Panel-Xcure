<?php

namespace Xcure\Listeners;

use Xcure\Facades\Activity;
use Illuminate\Contracts\Events\Dispatcher;
use Xcure\Events\Auth\ProvidedAuthenticationToken;
use Xcure\Extensions\Illuminate\Events\Contracts\SubscribesToEvents;

class TwoFactorListener implements SubscribesToEvents
{
    public function __invoke(ProvidedAuthenticationToken $event): void
    {
        Activity::event($event->recovery ? 'auth:recovery-token' : 'auth:token')
            ->withRequestMetadata()
            ->subject($event->user)
            ->log();
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(ProvidedAuthenticationToken::class, self::class);
    }
}
