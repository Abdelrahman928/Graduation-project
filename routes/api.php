<?php

use App\Http\Controllers\Api\V1\Auth\PartnerController;
use App\Http\Controllers\api\v1\auth\ChangePasswordController;
use App\Http\Controllers\api\v1\auth\EditProfileController;
use App\Http\Controllers\api\v1\auth\EmailVerificationController;
use App\Http\Controllers\api\v1\auth\HomePageController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\api\v1\auth\RedeemCodeController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\Auth\UserController;
use App\Http\Controllers\api\v1\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\NotificationController;
use App\Http\Controllers\Api\V1\Auth\RedeemHistoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', [LoginController::class, 'loginUser']);
    Route::post('/forgot_password', [ForgotPasswordController::class, 'getUserEmail']);
    
    Route::middleware(['auth:sanctum', 'abilities:reset-password'])->group(function () {
        Route::put('/forgot_password/reset', [ForgotPasswordController::class, 'resetPassword']);
        Route::post('/forgot_password/verify', [ForgotPasswordController::class, 'verifyOtp']);
    });

    Route::middleware(['auth:sanctum', 'abilities:access-user-account'])->group(function () {
        Route::get('/', HomePageController::class);
        Route::get('/profile/history', [RedeemHistoryController::class, 'index']);
        Route::get('/profile/history/{history}', [RedeemHistoryController::class, 'show']);
        Route::post('/verify-email', EmailVerificationController::class);
        Route::post('/logout', [LoginController::class, 'logoutUser']);
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/{notification:id}', [NotificationController::class, 'show']);
        Route::get('/profile/edit', UserController::class);
        Route::put('/profile/settings/change_password', ChangePasswordController::class);
        Route::put('/profile/edit/change_name', [EditProfileController::class, 'changeName']);
        Route::put('/profile/edit/change_email', [EditProfileController::class, 'changeEmail']);
        Route::patch('/enter_promo_code', RedeemCodeController::class);
        Route::get('/partners', [PartnerController::class, 'index']);
        Route::get('/partners/{partner}', [PartnerController::class, 'show']);
        Route::post('/partners/{partner}/redeem', [PartnerController::class, 'redeem']);
    });
});