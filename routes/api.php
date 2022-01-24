<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractsController;
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
Route::get('reset-password', [AuthController::class, 'reset_password']);
Route::post('verify/${method}', [AuthController::class, 'verify_client']);
Route::get('verification-code/${method}', [AuthController::class, 'send_verification_code']);

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
	Route::post('subscribe/{package_id}', [SubscriptionsController::class, 'subscribe']);
	Route::post('unsubscribe/{package_id}', [SubscriptionsController::class, 'unsubscribe']);
	Route::get('subscriptions/{user}', [SubscriptionsController::class, 'index']);
});
Route::fallback(function () {
	return response()->json([
		"success" => false,
		"message" => 'Page Not Found. If error persists, contact info@website.com'
	], 404);
});

//momo endpoints
// Route::get('/', [TestsMomoController::class, 'confirmOrder']);
