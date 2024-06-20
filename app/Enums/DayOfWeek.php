<?php

declare(strict_types=1);

namespace App\Enums;

use Carbon\CarbonInterface;
use Illuminate\Support\Str;

enum DayOfWeek: int
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;

    public function dayLocale(): string
    {
        return match ($this) {
            DayOfWeek::MONDAY => __('monday'),
            DayOfWeek::TUESDAY => __('tuesday'),
            DayOfWeek::WEDNESDAY => __('wednesday'),
            DayOfWeek::THURSDAY => __('thursday'),
            DayOfWeek::FRIDAY => __('friday'),
            DayOfWeek::SATURDAY => __('saturday'),
            DayOfWeek::SUNDAY => __('sunday'),
        };
    }

    public function dayLocaleUcFirst(): string
    {
        return Str::ucfirst($this->dayLocale());
    }

    public static function fromCarbonDate(CarbonInterface $date): DayOfWeek
    {
        return DayOfWeek::from($date->dayOfWeekIso);
    }

    public function isWeekDay(): bool
    {
        return $this->value < 6;
    }

    public function isWeekEnd(): bool
    {
        return $this->value >= 5;
    }

}
