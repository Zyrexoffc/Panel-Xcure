<?php

namespace Xcure\Repositories\Eloquent;

use Xcure\Models\RecoveryToken;

class RecoveryTokenRepository extends EloquentRepository
{
    public function model(): string
    {
        return RecoveryToken::class;
    }
}
