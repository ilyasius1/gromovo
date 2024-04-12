<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CottageIsReservedException extends Exception
{
    protected $code = 409;
    protected $message = 'Коттедж уже забронирован в выбранные даты';
}
