<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class BusinessException
 *
 * @package App\Exceptions
 */
class UserAuthException extends Exception
{
    /**
     * Error Data
     *
     * @var array
     */
    protected $errors = [];

    /**
     * BusinessException constructor.
     *
     * @param string         $message  Message
     * @param array          $errors   Errors
     * @param int            $code     Code
     * @param Throwable|null $previous Exception
     */
    public function __construct($message = "", array $errors = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * Error Data
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}

