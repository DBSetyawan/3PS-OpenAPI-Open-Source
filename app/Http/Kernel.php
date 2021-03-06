<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use SMartins\PassportMultiauth\Http\Middleware\AddCustomProvider;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\TrimStrings::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
            'bindings',
            // \App\Http\Middleware\AuthGates::class,
            // \App\Http\Middleware\SwaggerFix::class
        ],
        // 'client_credentials' => [
        //     CheckClientCredentials::class,
        //     'throttle:60,1',
        //     'bindings',
        // ],
        // 'customer' => [
        //     'throttle:60:1',
        //     'bindings',
        //     // \App\Http\Middleware\SwaggerFix::class

        // ],
        'client_credentials' => [
            CheckClientCredentials::class,
            'throttle:60,1',
            'bindings',
        ],
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\SetLocale::class,
        ],
    ];

    protected $routeMiddleware = [
        // 'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'client' => CheckClientCredentials::class,
        'swfix' => \App\Http\Middleware\SwaggerFix::class,
        'json.response' => \App\Http\Middleware\ForceJsonResponse::class,

        'multiauth' => \SMartins\PassportMultiauth\Http\Middleware\MultiAuthenticate::class,
        'oauth.providers' => \SMartins\PassportMultiauth\Http\Middleware\AddCustomProvider::class,

        'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,   
        'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
    ];
}
