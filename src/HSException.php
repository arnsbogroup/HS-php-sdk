<?php

namespace Heysender;

use Exception;

class HSException extends Exception
{
    /**
     * Initialize the HSException
     *
     * @param string $message Exception message
     * @param int $code Exception code (optional)
     * @param Throwable|null $previous Previous exception for chaining (optional)
     */
    public function __construct(string $message, int $code = 0, ?string $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
