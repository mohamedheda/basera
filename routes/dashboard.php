<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Mangers\MangerController;
use App\Http\Controllers\Dashboard\Roles\RoleController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use App\Http\Controllers\Dashboard\User\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('/', function () {
//     return view('dashboard.site.index');
// });

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function (): void {
        Route::get('login', [AuthController::class, '_login'])->name('_login');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('/');
        Route::resource('users', UserController::class);
    });
    Route::resource('settings', SettingController::class)->only('edit', 'update');
    Route::post('update-password', [SettingController::class, 'updatePassword'])->name('update-password');
    Route::resource('roles', RoleController::class);
    Route::get('role/{id}/managers', [RoleController::class, 'mangers'])->name('roles.mangers');
    Route::controller(MangerController::class)->prefix('managers')->name('managers.')
        ->group(function () {
            Route::get('/{role}/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::post('/toggle/{id}', 'toggle')->name('toggle');
            Route::get('/{manager}/edit', 'edit')->name('edit');
            Route::put('/{manager}', 'update')->name('update');
            Route::delete('/{manager}', action: 'destroy')->name('destroy');
        });
    // Route::resource('managers', MangerController::class)->except('show', 'index');
});
