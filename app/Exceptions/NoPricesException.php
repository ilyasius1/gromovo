<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class NoPricesException extends Exception
{
    public function __construct(string $message = "Не найдено цен по запрошенным параметрам", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
