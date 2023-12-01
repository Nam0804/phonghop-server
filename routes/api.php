<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Route
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forget-password', [AuthController::class, 'forgetPassword']);
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/auth/reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::resource('companies', CompanyController::class);
Route::resource('users', UserApiController::class);
Route::get('/users/company/{company_id}', [UserApiController::class, 'CompanyUsers']);
// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);
});
