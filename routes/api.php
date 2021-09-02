<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ReferalController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\TestsMomoController;

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
    Route::apiResource('transactions', TransactionsController::class);
});

Route::fallback(function () {
    return response()->json([
        "success" => false,
        "message" => 'Page Not Found. If error persists, contact info@website.com'
    ], 404);
});

//momo endpoints
Route::get('/', [TestsMomoController::class, 'confirmOrder']);