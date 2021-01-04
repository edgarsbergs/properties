<?php

namespace App\Exceptions;

use Exception;

class ApiException  extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return bool
     */
    public function report()
    {
        \Log::debug('Cannot access API');

        return false;
    }
}
