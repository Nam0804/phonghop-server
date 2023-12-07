<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function()
{
    /**
     * Home Routes
     */
    // Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');
        /**
         * Forgot Password Routes
         */
        // Route::get('/forgot-password', 'LoginController@show')->name('forgot-password.show');
        // Route::post('/forgot-password', 'LoginController@login')->name('orgot-password.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        if ( Gate::allows('admin')) {
            Route::get('/forgot-password-admin', 'LoginController@show')->name('forgot-password.show');
        }
//        Route::resource('roles', \App\Http\Controllers\Api\RolesAndPermissionsController::class);
//        Route::resource('users', \App\Http\Controllers\UserController::class);
//        Route::resource('company', \App\Http\Controllers\Api\Company\CompanyController::class);
    });

    //Authorization Routes
//    Route::group(['middleware' => ['role:admin']], function () {
//        Route::get('index', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'index']);
//        Route::get('show-roles', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showRole']);
//        Route::get('show-permissions', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showPermissions']);
//        Route::post('create-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'createNewRole']);
//        Route::post('edit-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'editRole']);
//    });
//
//    Route::group(['middleware' => ['role:manager']], function () {
//        Route::get('index', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'index']);
//        Route::get('show-roles', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showRole']);
//        Route::get('show-permissions', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showPermissions']);
//        Route::post('edit-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'editRole']);
//    });
//
//    Route::group(['middleware' => ['role:user']], function () {
//        Route::get('index', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'index']);
//        Route::get('show-roles', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showRole']);
//        Route::get('show-permissions', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'showPermissions']);
//    });
//
//    Route::group(['middleware' => ['role:guest']], function () {
//        Route::get('index', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'index']);
//        Route::get('/register', 'RegisterController@show')->name('register.show');
//        Route::post('/register', 'RegisterController@register')->name('register.perform');
//    });
    //Queue mail jobs routes
    Route::get('reset-password/{token}',[AuthController::class,'resetPassword'])->name('reset-password');
    Route::get('send-mail', [MailController::class, 'sendMail']);

//    Route::get('set-role', [\App\Http\Controllers\Api\RolesAndPermissionsController::class, 'assignRole']);
});

