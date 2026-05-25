<?php

namespace App\Exceptions;

use Exception;

class WeatherServiceException extends Exception
{
    public function __construct(
        string $message,
        protected int $status = 500
    ) {
        parent::__construct($message);
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}