<?php

use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\User\UserApiController;
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
Route::resource('admins', AdminApiController::class);
Route::get('/auth/verify-email/{token}', [UserApiController::class, 'verifyEmail'])->name('verify.email');
// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('index', [\App\Http\Controllers\Api\Company\CompanyController::class, 'index']);
    Route::get('show-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'show']);
    Route::post('update-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'update']);
    Route::post('add-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'store']);
    Route::delete('delete-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'destroy']);
});

Route::group(['middleware' => ['role:manager']], function () {
    Route::get('index', [\App\Http\Controllers\Api\Company\CompanyController::class, 'index']);
    Route::get('show-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'show']);
    Route::post('update-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'update']);
});

Route::group(['middleware' => ['role:user']], function () {
    Route::get('index', [\App\Http\Controllers\Api\Company\CompanyController::class, 'index']);
    Route::get('show-company', [\App\Http\Controllers\Api\Company\CompanyController::class, 'show']);
});

Route::group(['middleware' => ['role:guest']], function () {
    Route::get('index-for-guest', [\App\Http\Controllers\Api\Company\CompanyController::class, 'index']);
});
Route::get('/set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);

