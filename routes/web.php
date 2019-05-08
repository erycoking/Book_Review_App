<?php

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


Route::get('/', function () { return response()->json(['data'=> 'welcome to book review api'], 200); });
Route::post('register', 'AuthController@register')->name('api.register');
Route::post('login', 'AuthController@login')->name('api.login');
Route::apiResource('books', 'BookController');
Route::post('books/{book}/ratings', 'RatingController@store')->name('rating.store');
// Route::fallback(function(){
//     return response()->json([
//         'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
// });





