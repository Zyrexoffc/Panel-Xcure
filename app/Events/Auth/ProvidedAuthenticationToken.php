<?php

namespace Xcure\Events\Auth;

use Xcure\Models\User;
use Xcure\Events\Event;

class ProvidedAuthenticationToken extends Event
{
    public function __construct(public User $user, public bool $recovery = false)
    {
    }
}
