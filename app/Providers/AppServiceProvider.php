<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use App\Models\Passport\Client;
use Illuminate\Routing\UrlGenerator;
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
        //    $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (config('app.production')) {
            $url->forceScheme('http');
        }

        // Client::creating(function (Client $client){
        //     $client->incrementing = false;
        //     $client->id = Str::uuid();
        // });

        // Client::retrieved(function (Client $client){
        //     $client->incrementing = false;
        // });
    }
}
