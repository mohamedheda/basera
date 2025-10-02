<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\Otp\OtpController;
use App\Http\Controllers\Api\V1\Auth\Password\PasswordController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Investment\InvestmentController;
use App\Http\Controllers\Api\V1\Subscription\SubscriptionController;
use App\Http\Controllers\Api\V1\Risk\RiskAssessmentController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut');
    });
    Route::get('what-is-my-platform', 'whatIsMyPlatform');
});

// OTP Routes
Route::group(['prefix' => 'otp', 'controller' => OtpController::class], function () {
    Route::post('send', 'send');
    Route::post('verify', 'verify');
    Route::post('resend', 'resend');
});

// Password Routes
Route::group(['prefix' => 'password', 'controller' => PasswordController::class], function () {
    Route::post('forgot', 'forgot');
    Route::post('reset', 'reset');
    Route::post('change', 'change')->middleware('auth:api');
});

// User Routes (Protected)
Route::group(['prefix' => 'user', 'middleware' => 'auth:api', 'controller' => UserController::class], function () {
    Route::post('register', 'register'); // Complete registration with profile
    Route::get('profile', 'profile');
    Route::put('profile', 'updateProfile');
    Route::post('change-password', 'changePassword');
    Route::get('dashboard', 'dashboard');
});

// Investment Routes
Route::group(['prefix' => 'investments', 'controller' => InvestmentController::class], function () {
    Route::get('/', 'index'); // Get all opportunities
    Route::get('search', 'search'); // Search opportunities
    Route::get('statistics', 'statistics'); // Get statistics
    Route::get('{id}', 'show'); // Get opportunity details

    // Protected routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('recommendations', 'getRecommendations'); // Get personalized recommendations
    });
});

// Subscription Routes
Route::group(['prefix' => 'subscriptions', 'controller' => SubscriptionController::class], function () {
    Route::get('packages', 'index'); // Get all packages
    Route::get('packages/{id}', 'show'); // Get package details
    Route::get('statistics', 'statistics'); // Get statistics

    // Protected routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('subscribe', 'subscribe'); // Subscribe to package
        Route::get('my-subscriptions', 'userSubscriptions'); // Get user subscriptions
        Route::get('active', 'activeSubscription'); // Get active subscription
        Route::post('cancel', 'cancelSubscription'); // Cancel subscription
    });
});

// Risk Assessment Routes (Protected)
Route::group(['prefix' => 'risk', 'middleware' => 'auth:api', 'controller' => RiskAssessmentController::class], function () {
    Route::get('/', 'show'); // Get user's risk assessment
    Route::post('/', 'store'); // Create/update risk assessment
    Route::get('questions', 'questions'); // Get assessment questions
    Route::get('profile-explanation', 'profileExplanation'); // Get profile explanation
});
