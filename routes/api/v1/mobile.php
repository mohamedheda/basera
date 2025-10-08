<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\Otp\OtpController;
use App\Http\Controllers\Api\V1\Auth\Password\PasswordController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Investment\InvestmentController;
use App\Http\Controllers\Api\V1\Subscription\SubscriptionController;
use App\Http\Controllers\Api\V1\Risk\RiskAssessmentController;
use App\Http\Controllers\Api\RegistrationQuestionController;
use App\Http\Controllers\Api\V1\BankController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'registration-questions', 'controller' => RegistrationQuestionController::class], function () {
    Route::get('/', 'index');
});
Route::group(['prefix' => 'banks', 'controller' => BankController::class], function () {
    Route::get('/', 'index');
});
Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut');
    });
});


Route::group(['prefix' => 'otp', 'controller' => OtpController::class], function () {
    Route::post('send', 'send');
    Route::post('verify', 'verify');
});


Route::group(['prefix' => 'password', 'controller' => PasswordController::class], function () {
    Route::post('forgot', 'forgot');
    Route::post('reset', 'reset');
    Route::post('change', 'updatePassword')->middleware('auth:api');
});


Route::group(['prefix' => 'user', 'middleware' => 'auth:api', 'controller' => UserController::class], function () {
    Route::post('register', 'register');
    Route::get('profile', 'profile');
    Route::post('profile', 'updateProfile');
    Route::post('change-password', 'changePassword');
    Route::get('dashboard', 'dashboard');
});


Route::group(['prefix' => 'investments', 'controller' => InvestmentController::class], function () {
    Route::get('/', 'index');
    Route::get('search', 'search');
    Route::get('statistics', 'statistics');
    Route::get('{id}', 'show');


    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('recommendations', 'getRecommendations');
    });
});


Route::group(['prefix' => 'subscriptions', 'controller' => SubscriptionController::class], function () {
    Route::get('packages', 'index');
    Route::get('packages/{id}', 'show');
    Route::get('statistics', 'statistics');


    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('subscribe', 'subscribe');
        Route::get('my-subscriptions', 'userSubscriptions');
        Route::get('active', 'activeSubscription');
        Route::post('cancel', 'cancelSubscription');
    });
});


Route::group(['prefix' => 'risk', 'middleware' => 'auth:api', 'controller' => RiskAssessmentController::class], function () {
    Route::get('/', 'show');
    Route::post('/', 'store');
    Route::get('questions', 'questions');
    Route::get('profile-explanation', 'profileExplanation');
});
