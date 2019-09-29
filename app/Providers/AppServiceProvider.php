<?php

namespace App\Providers;

use App\Services\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;
use App\Services\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client(new GuzzleClient, new Log(), env('CMC_API_KEY'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
