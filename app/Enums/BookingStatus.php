<?php

declare(strict_types=1);

namespace App\Enums;

enum BookingStatus: int
{
    case DRAFT = 1001;
    case CONFIRMED = 1002;
    case CANCELLED = 1003;

    public function status(): string
    {
        return match ($this) {
            BookingStatus::DRAFT => 'Черновик',
            BookingStatus::CONFIRMED => 'Подтверждён',
            BookingStatus::CANCELLED => 'Отменён'
        };
    }
}
