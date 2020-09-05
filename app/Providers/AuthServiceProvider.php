<?php

namespace App\Providers;

use Route;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // if (!app()->runningInConsole()) {
        //     Passport::routes();
        // };
        // Passport::routes();

        // Route::group(['middleware' => ['auth:customer']], function () {
            // Passport::routes();
            
            // Passport::routes(function ($router) {
            //     $router->forAccessTokens();
            //     $router->forPersonalAccessTokens();
            //     $router->forTransientTokens();
            // });
            
            Passport::routes();

            Passport::tokensCan([
                'shipment-view' => 'Can view shipment customer', 
                'create-address' => 'Can add address',   
                'item-customers' => 'Can view Item customer',   
                'city-view' => 'Can view City',   
                'create-address-book' => 'Can Create Address Book',   
                'view-address-book' => 'Can view Address Book',   
                'create-shipment' => 'Can Create Shipment customer',   
            ]);
            
            //expires token this
            Passport::tokensExpireIn(Carbon::now()->addDays(30));
            
            //expires personal access token this
            Passport::personalAccessTokensExpireIn(Carbon::now()->addDays(30));
            
            //automatically refresh token in at this
            Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

            // Passport::cookie('3PS_CSRF_ACCESS_TOKEN');
            
            Route::group(['middleware' => 'oauth.providers'], function () {
                Passport::routes(function ($router) {
                    $router->forAccessTokens();
                    $router->forPersonalAccessTokens();
                    $router->forTransientTokens();
                    
                    return $router;
                });
            });
        // });
    }
}
