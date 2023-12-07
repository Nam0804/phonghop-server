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
Route::get('/auth/verify-email/{token}', [UserApiController::class, 'verifyEmail'])->name('verify.email');

// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('roles', \App\Http\Controllers\Api\RolesAndPermissionsController::class);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('admins', AdminApiController::class);
        Route::get('index', [CompanyController::class, 'index']);
        Route::get('/companies/show-company', [CompanyController::class, 'show']);
        Route::post('update-company', [CompanyController::class, 'update']);
        Route::post('add-company', [CompanyController::class, 'store']);
        Route::delete('delete-company', [CompanyController::class, 'destroy']);
    });

    Route::middleware(['role:manager'])->group(function () {
        Route::get('index', [CompanyController::class, 'index']);
        Route::get('/companies/show-company', [CompanyController::class, 'show']);
        Route::post('update-company', [CompanyController::class, 'update']);
    });

    Route::middleware(['role:user'])->group(function () {
        Route::get('index', [CompanyController::class, 'index']);
        Route::get('/companies/show-company', [CompanyController::class, 'show']);
    });

    Route::middleware(['role:guest'])->group(function () {
        Route::get('index', [CompanyController::class, 'index']);
    });
});

Route::get('/set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);
