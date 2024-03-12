<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class PriceObserver
{
    /**
     * @return void
     */
    public function created(): void
    {
        Cache::forget('prices');
    }

    public function updated():void
    {
        Cache::forget('prices');
    }
}
