<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;



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
    });
    Route::get('reset-password/{token}',[AuthController::class,'resetPassword'])->name('reset-password');
    Route::get('send-mail', [MailController::class, 'sendMail']);
});

