<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ServiceObserver
{
    public function created(): void
    {
        Cache::forget('services');
    }

    public function updated(): void
    {
        Cache::forget('services');
    }
}
