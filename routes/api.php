<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\NjangiGroupController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ReferalController;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\RegistrationFeesController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TransactionsController;
use Laravel\Cashier\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('signup', [AuthController::class, 'signup']);
Route::post('signin', [AuthController::class, 'signin']);
Route::post('reset-password', [AuthController::class, 'reset_password']);
Route::post('verify/${method}', [AuthController::class, 'verify_client']);
Route::post('forgot-password', [AuthController::class, 'forgot_password']);
Route::post('forgot-password/confirm-code', [AuthController::class, 'confirm_password_reset_code']);

Route::get('test', fn () => response()->json([
    "success" => true,
    "data" => UserResource::collection(User::all()),
]));

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::apiResource('users', UsersController::class);
    Route::apiResource('packages', PackagesController::class);
    Route::apiResource('profiles', ProfilesController::class);
    Route::apiResource('contracts', ContractsController::class);
    Route::apiResource('referals', ReferalController::class);
    Route::apiResource('registration', RegistrationFeesController::class);
    Route::apiResource('savings', SavingsController::class);
    Route::apiResource('njangi-groups', NjangiGroupController::class)->except(['create', 'show', 'edit']);
    Route::apiResource('cash-transfers', NjangiGroupController::class)->except(['create', 'edit']);
    Route::post('subscribe/{package_id}', [SubscriptionsController::class, 'subscribe']);
    Route::post('unsubscribe/{package_id}', [SubscriptionsController::class, 'unsubscribe']);
    Route::get('subscribers/{package_id}', [SubscriptionsController::class, 'subscribers']);
    Route::get('subscriptions', [SubscriptionsController::class, 'index']);
    // Route::get('subscribers', [SubscriptionsController::class, 'index']);
    // Route::post('payments/sendMoney', [PaymentController::class, 'sendMoney']);
});
Route::fallback(function () {
    return response()->json([
        "success" => false,
        "message" => 'Page Not Found. If error persists, contact info@website.com'
    ], 404);
});