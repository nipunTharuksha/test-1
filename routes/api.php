<?php

use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRegistrationController;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/validate-token', [UserRegistrationController::class, 'validateToken']);
Route::post('/register', [UserRegistrationController::class, 'store']);
Route::post('/activate-account', [UserRegistrationController::class, 'activateAccount']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/invitation', [AdminUserManagementController::class, 'store']);
    Route::apiResource('/users', UserController::class);
});
