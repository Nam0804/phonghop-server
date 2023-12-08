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
Route::resource('admins', AdminApiController::class);
// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('roles', \App\Http\Controllers\Api\RolesAndPermissionsController::class);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('index', [CompanyController::class, 'index']);
    Route::get('/companies/show-company', [CompanyController::class, 'show']);
    Route::post('update-company', [CompanyController::class, 'update']);
    Route::post('add-company', [CompanyController::class, 'store']);
    Route::delete('delete-company', [CompanyController::class, 'destroy']);

    Route::get('list-auth', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'index']);
    Route::get('show-role/{user_id}', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showRole']);
    Route::get('show-permissions', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showPermissions']);
    Route::post('create-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'createNewRole']);
    Route::post('edit-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'editRole']);
    Route::post('update-permissions', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'updatePermissions']);
});

Route::get('/set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);
