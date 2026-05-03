<?php

namespace Xcure\Repositories\Eloquent;

use Xcure\Models\User;
use Xcure\Contracts\Repository\UserRepositoryInterface;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Return the model backing this repository.
     */
    public function model(): string
    {
        return User::class;
    }
}
