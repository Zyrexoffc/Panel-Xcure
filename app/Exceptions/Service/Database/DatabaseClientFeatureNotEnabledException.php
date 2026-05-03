<?php

namespace Xcure\Exceptions\Service\Database;

use Xcure\Exceptions\XcureException;

class DatabaseClientFeatureNotEnabledException extends XcureException
{
    public function __construct()
    {
        parent::__construct('Client database creation is not enabled in this Panel.');
    }
}
