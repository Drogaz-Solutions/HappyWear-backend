<?php

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

Route::get('/', function () {
    return view('test');
});

// Route::get('/legal', function () {
//     return view('legal.tos');
// });

Route::group(['prefix' => 'legal'], function () {
    Route::get('/terms-of-service', function () {
        return view('legal.tos');
    });
    Route::get('/privacy-policy', function () {
        return view('legal.pp');
    });
    Route::get('/refund-policy', function () {
        return view('legal.refund');
    });
    Route::get('/', function () {
        return view('legal.home');
    });
});
