<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

/*Route::get('/login2', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login2');*/

/*Route::post('/login2', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');*/


Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

                
Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth')
                ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth');
Route::get('/forgot-password', [AuthenticateController::class, 'forgotPassword'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/reset-password', [MailController::class, 'resetPassword'])
                ->middleware('guest')
                ->name('password.update');

Route::get('/change-password/{id}', [MailController::class, 'showResetPasswordForm'])
                ->middleware(['guest'])
                ->name('show-change-password');

Route::post('change-password', [MailController::class, 'submitResetPasswordForm'])
                ->middleware(['guest'])
                ->name('reset.password.post');

Route::get('/verify-email', [AuthenticateController::class, 'verifyEmail'])
                ->middleware('guest')
                ->name('verification.notice');


Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth');

Route::get('/logoutidle', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logoutidle');

Route::get('/login-tjb', [AuthenticateController::class, 'create'])
                ->middleware('guest')
                ->name('login-tjb');
                

Route::post('/login', [AuthenticateController::class, 'store'])
                ->middleware('guest')
                ->name('action-login');

Route::get('/login', [AuthenticateController::class, 'createtjb'])
                ->middleware('guest')
                ->name('login');

Route::get('/', function () {
    return redirect('/login');
});