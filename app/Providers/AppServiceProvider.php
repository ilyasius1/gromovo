<?php

namespace App\Providers;

use App\QueryBuilders\PricesQueryBuilder;
use App\QueryBuilders\QueryBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Query builders
        $this->app->bind(QueryBuilder::class, PricesQueryBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
