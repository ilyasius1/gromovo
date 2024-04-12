<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class WrongReservationAmountException extends Exception
{
    protected $code = 409;
    protected $message = 'Некорректная сумма';
}
