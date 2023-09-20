<?php

namespace App\Framework\Exceptions;

use Exception;
use Throwable;

class FrameworkException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $message = "Framework Exception: " . $message;
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}