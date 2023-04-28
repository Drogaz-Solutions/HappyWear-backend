<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'v1'], function() {

    Route::post('/register', 'AuthController@register')->name('api.register');
    Route::post('/login', 'AuthController@login')->name('api.login');
    Route::post('/autologin', 'AuthController@autologin')->name('api.autologin');

    Route::post('/sell', 'ProductController@sell')->name('api.sell');

});
