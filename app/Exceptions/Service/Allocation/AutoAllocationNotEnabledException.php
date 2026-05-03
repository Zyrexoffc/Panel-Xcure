<?php

namespace Xcure\Exceptions\Service\Allocation;

use Xcure\Exceptions\DisplayException;

class AutoAllocationNotEnabledException extends DisplayException
{
    /**
     * AutoAllocationNotEnabledException constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Server auto-allocation is not enabled for this instance.'
        );
    }
}
