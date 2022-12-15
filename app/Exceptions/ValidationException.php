<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected static $statusCode = 422;

    public function __construct(
        protected $validationMsgs,
        $message = 'Errors occurred because validation didn\'t pass',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getValidationErrors()
    {
        return $this->validationMsgs;
    }

    public function getStatusCode()
    {
        return self::$statusCode;
    }
}