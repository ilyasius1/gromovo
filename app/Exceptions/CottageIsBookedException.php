<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class CottageIsBookedException extends Exception
{
    public function __construct(string $message = "Коттедж уже забронирован в выбранные даты", int $code = 409, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
