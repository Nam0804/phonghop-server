<?php

use App\Http\Controllers\Api\Admin\AdminApiController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\MeetingRoom\MeetingRoomController;
use App\Http\Controllers\Api\User\UserApiController;
use App\Models\Company;
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
Route::resource('admins', AdminApiController::class);
Route::post('/user/register/company',[CompanyController::class,'registerNewCompany']);
Route::get('set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);
Route::resource('bookings', BookingController::class);

// Authenticated Route
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', [UserApiController::class, 'profile']);
    Route::post('create-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'createNewRole']);
    Route::get('/auth/user/reset-password', [UserApiController::class, 'changePassword']);
    Route::post('/bookings/history/{user_id}', [BookingController::class, 'bookingHistory']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/external-bookings', [BookingController::class, 'loggedStore']);
    Route::get('/meeting-rooms/listing', [MeetingRoomController::class, 'CompanyMeetingRooms']);

    Route::get('index-companies', [CompanyController::class, 'index'])->middleware('permission:show-all-company');
    Route::post('store-company', [CompanyController::class, 'store'])->middleware('permission:add-company');
    Route::get('show-company/{id}', [CompanyController::class, 'show'])->middleware('permission:show-company');
    Route::put('update-company/{id}', [CompanyController::class, 'update'])->middleware('permission:update-company');
    Route::delete('delete-company/{id}', [CompanyController::class, 'destroy'])->middleware('permission:delete-company');

    Route::get('index-meeting-rooms', [MeetingRoomController::class, 'index'])->middleware('permission:show-all-meeting-rooms');
    Route::post('store-meeting-room', [MeetingRoomController::class, 'store'])->middleware('permission:add-meeting-rooms');
    Route::get('show-meeting-room/{id}', [MeetingRoomController::class, 'show'])->middleware('permission:show-meeting-rooms');
    Route::put('update-meeting-room/{id}', [MeetingRoomController::class, 'update'])->middleware('permission:update-meeting-rooms');
    Route::delete('delete-meeting-room/{id}', [MeetingRoomController::class, 'destroy'])->middleware('permission:delete-meeting-rooms');

    Route::get('index-users', [UserApiController::class, 'index'])->middleware('permission:show-users-information');
    Route::post('store-user', [UserApiController::class, 'store'])->middleware('permission:add-new-users');
    Route::get('show-user/{id}', [UserApiController::class, 'show'])->middleware('permission:show-users-details-information');
    Route::put('update-user/{id}', [UserApiController::class, 'update'])->middleware('permission:update-user-information');
    Route::delete('delete-users/{id}', [UserApiController::class, 'destroy'])->middleware('permission:delete-user');


    Route::group(['middleware' => ['role:admin']], function (){
       Route::resource('admins', AdminApiController::class);
       Route::resource('roles-and-permissions', \App\Http\Controllers\Api\RolesAndPermissionsController::class);
    });
});
