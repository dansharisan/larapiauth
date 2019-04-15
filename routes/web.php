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
Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => 'web'], function () {
    Route::get(\Config::get('l5-swagger.routes')['api'], '\L5Swagger\Http\Controllers\SwaggerController@api')->name('l5swagger.api');
});

Route::get('/{vue_capture?}', 'AppController@index')
    ->middleware(['speed'])
    ->where('vue_capture', '[\/\w\.\,\-]*');
