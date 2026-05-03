<?php

namespace Xcure\Events\Server;

use Xcure\Events\Event;
use Xcure\Models\Server;
use Illuminate\Queue\SerializesModels;

class Saved extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Server $server)
    {
    }
}
