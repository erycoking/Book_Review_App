<?php

use Illuminate\Http\Request;

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


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register')->name('api.register');
    Route::post('login', 'AuthController@login')->name('api.login');
    Route::post('refresh', 'AuthController@refresh')->name('api.refresh');
    Route::post('me', 'AuthController@me')->name('api.me');
});

Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::apiResource('books', 'BookController');
    Route::post('books/{book}/ratings', 'RatingController@store')->name('rating.store');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
});
