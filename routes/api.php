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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([ 'middleware' => 'api','prefix' => 'person'], function () {
    Route::get('get', 'PersonController@get');
    Route::post('create', 'PersonController@create');
    Route::post('update', 'PersonController@update');
    Route::post('delete', 'PersonController@destroy');
});
Route::group([ 'middleware' => 'api','prefix' => 'vehicle'], function () {
    Route::get('get', 'VehiculeController@get');
    Route::post('create', 'VehiculeController@create');
    Route::post('update', 'VehiculeController@update');
    Route::post('delete', 'VehiculeController@destroy');
});
