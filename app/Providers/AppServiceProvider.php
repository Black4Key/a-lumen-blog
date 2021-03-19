<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
            Log::debug($query->sql . ' - ' . serialize($query->bindings), ['query']);
        });
    }
}
