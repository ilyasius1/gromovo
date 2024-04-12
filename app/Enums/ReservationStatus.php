<?php

declare(strict_types=1);

namespace App\Enums;

enum ReservationStatus: int
{
    case DRAFT = 1001;
    case CONFIRMED = 1002;
    case CANCELLED = 1003;

    public function status(): string
    {
        return match ($this) {
            ReservationStatus::DRAFT => 'Черновик',
            ReservationStatus::CONFIRMED => 'Подтверждён',
            ReservationStatus::CANCELLED => 'Отменён'
        };
    }
}
