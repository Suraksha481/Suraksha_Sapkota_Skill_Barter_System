<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyEmailCodeController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::put('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');

    // Email Verification Code routes
    Route::get('verify-email-code', [VerifyEmailCodeController::class, 'show'])
                ->name('verify-email-code.show');

    Route::post('verify-email-code', [VerifyEmailCodeController::class, 'verify'])
                ->name('verify-email-code.verify');

    Route::post('verify-email-code/resend', [VerifyEmailCodeController::class, 'resend'])
                ->name('verify-email-code.resend');

    // OAuth routes
    Route::get('auth/{provider}/redirect', [OAuthController::class, 'redirect'])
                ->name('oauth.redirect')
                ->where('provider', 'google|apple');

    Route::get('auth/{provider}/callback', [OAuthController::class, 'callback'])
                ->name('oauth.callback')
                ->where('provider', 'google|apple');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // OAuth disconnect route
    Route::post('auth/{provider}/disconnect', [OAuthController::class, 'disconnect'])
                ->name('oauth.disconnect')
                ->where('provider', 'google|apple');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

