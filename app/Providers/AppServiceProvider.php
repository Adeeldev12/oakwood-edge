<?php

namespace App\Providers;

use App\Models\Client;
use App\Observers\ClientObserver;
use App\Observers\GlobalModelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // Model::observe(GlobalModelObserver::class);
         Client::observe(ClientObserver::class);
    }
}
