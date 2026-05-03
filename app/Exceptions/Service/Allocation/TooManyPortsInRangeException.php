<?php

namespace Xcure\Exceptions\Service\Allocation;

use Xcure\Exceptions\DisplayException;

class TooManyPortsInRangeException extends DisplayException
{
    /**
     * TooManyPortsInRangeException constructor.
     */
    public function __construct()
    {
        parent::__construct(trans('exceptions.allocations.too_many_ports'));
    }
}
