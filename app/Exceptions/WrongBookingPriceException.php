<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class WrongBookingPriceException extends Exception
{
    public function __construct(string $message = "Некорректная сумма", int $code = 409, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
