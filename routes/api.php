<?php

use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\MeetingRoom\MeetingRoomcontroller;
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
Route::get('/users/company/{company_id}', [UserApiController::class, 'CompanyUsers']);
Route::get('/auth/verify-email/{token}', [UserApiController::class, 'verifyEmail'])->name('verify.email');
Route::get('set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);
Route::post('create-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'createNewRole']);
// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/user/reset-password', [UserApiController::class, 'changePassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/meeting-rooms/listing/{company_id}', [MeetingRoomcontroller::class, 'CompanyMeetingRooms']);

    Route::get('index-companies', [CompanyController::class, 'index'])->middleware('permission:show-all-company');
    Route::post('store-company', [CompanyController::class, 'store'])->middleware('permission:add-company');
    Route::get('show-company', [CompanyController::class, 'show'])->middleware('permission:show-company');
    Route::put('update-company', [CompanyController::class, 'update'])->middleware('permission:update-company');
    Route::delete('delete-company', [CompanyController::class, 'delete'])->middleware('permission:delete-company');

    Route::get('index-meeting-rooms', [MeetingRoomcontroller::class, 'index'])->middleware('permission:show-all-meeting-rooms');
    Route::post('store-meeting-room', [MeetingRoomcontroller::class, 'store'])->middleware('permission:add-meeting-rooms');
    Route::get('show-meeting-room', [MeetingRoomcontroller::class, 'show'])->middleware('permission:show-meeting-rooms');
    Route::put('update-meeting-room', [MeetingRoomcontroller::class, 'update'])->middleware('permission:update-meeting-rooms');
    Route::delete('delete-meeting-room', [MeetingRoomcontroller::class, 'delete'])->middleware('permission:delete-meeting-rooms');

    Route::get('index-users', [UserApiController::class, 'index'])->middleware('permission:show-users-information');
    Route::post('store-user', [UserApiController::class, 'store'])->middleware('permission:add-new-users');
    Route::get('show-user', [UserApiController::class, 'show'])->middleware('permission:show-users-details-information');
    Route::put('update-user', [UserApiController::class, 'update'])->middleware('permission:update-user-information');
    Route::delete('delete-users', [UserApiController::class, 'delete'])->middleware('permission:delete-user');


    Route::group(['middleware' => ['role:admin']], function (){
       Route::resource('admins', AdminApiController::class);
       Route::resource('roles-and-permissions', \App\Http\Controllers\Api\RolesAndPermissionsController::class);
    });

});
