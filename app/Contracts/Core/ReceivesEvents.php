<?php

namespace Xcure\Contracts\Core;

use Xcure\Events\Event;

interface ReceivesEvents
{
    /**
     * Handles receiving an event from the application.
     */
    public function handle(Event $notification): void;
}
