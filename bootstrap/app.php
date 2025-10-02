<?php

use App\Http\Middleware\LocalizeApi;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            if (app()->isProduction()) {
                Route::group([
                    'middleware' => ['api', 'localize-api'],
                    'domain' => env('PRODUCTION_API_SUBDOMAIN'),
                ], function () {
                    Route::prefix('api/v1')->group(function () {
                        Route::prefix('website')->group(base_path('routes/api/v1/website.php'));
                        Route::prefix('mobile')->group(base_path('routes/api/v1/mobile.php'));
                        Route::prefix(prefix: 'dashboard')->group(base_path('routes/api/v1/dashboard.php'));
                    });
                });

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));

                Route::middleware('web')
                    ->domain('PRODUCTION_DASHBOARD_SUBDOMAIN')
                    ->group(base_path('routes/dashboard.php'));
            } else {
                Route::group(['middleware' => ['api', 'localize-api']], function () {
                    Route::prefix('api/v1')->group(function () {
                        Route::prefix('website')->group(base_path('routes/api/v1/website.php'));
                        Route::prefix('mobile')->group(base_path('routes/api/v1/mobile.php'));
                        Route::prefix('dashboard')->group(base_path('routes/api/v1/dashboard.php'));
                    });
                });

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));

                Route::middleware('web')
                    ->group(base_path('routes/dashboard.php'));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localize-api' => LocalizeApi::class,
            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            // 'permission' => MiddlewarePermission::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();
