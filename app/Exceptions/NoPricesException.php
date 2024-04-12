<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class NoPricesException extends Exception
{
    protected $code = 404;
    protected $message = 'Не найдено цен по запрошенным параметрам';
}
