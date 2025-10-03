<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Mangers\MangerController;
use App\Http\Controllers\Dashboard\Roles\RoleController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\RegistrationQuestion\RegistrationQuestionController;
use App\Http\Controllers\Dashboard\Bank\BankController;
use App\Http\Controllers\Dashboard\SubscriptionPackage\SubscriptionPackageController;
use App\Http\Controllers\Dashboard\UserSubscription\UserSubscriptionController;
use App\Http\Controllers\Dashboard\InvestmentOpportunity\InvestmentOpportunityController;
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

        // Registration Questions Routes
        Route::resource('registration-questions', RegistrationQuestionController::class);
        Route::post('registration-questions/{id}/toggle', [RegistrationQuestionController::class, 'toggleStatus'])
            ->name('registration-questions.toggle');

        Route::resource('banks', BankController::class);
        Route::post('banks/{id}/toggle', [BankController::class, 'toggleStatus'])
            ->name('banks.toggle');

        // Subscription Packages Routes
        Route::resource('subscription-packages', SubscriptionPackageController::class);
        Route::post('subscription-packages/{id}/toggle', [SubscriptionPackageController::class, 'toggleStatus'])
            ->name('subscription-packages.toggle');
        Route::post('subscription-packages/{id}/toggle-popular', [SubscriptionPackageController::class, 'togglePopular'])
            ->name('subscription-packages.toggle-popular');

        // User Subscriptions Routes
        Route::resource('subscriptions', UserSubscriptionController::class)->only(['index', 'show', 'destroy']);
        Route::post('subscriptions/{id}/status/{status}', [UserSubscriptionController::class, 'updateStatus'])
            ->name('subscriptions.update-status');

        // Investment Opportunities Routes
        Route::resource('investment-opportunities', InvestmentOpportunityController::class);
        Route::post('investment-opportunities/{id}/toggle', [InvestmentOpportunityController::class, 'toggleStatus'])
            ->name('investment-opportunities.toggle');
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
