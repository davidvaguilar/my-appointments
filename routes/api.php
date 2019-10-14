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

Route::post('/login', 'AuthController@login');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Public resources
Route::get('/specialties', 'SpecialtyController@index');
Route::get('/specialties/{specialty}/doctors', 'SpecialtyController@doctors');
Route::get('/schedule/hours', 'ScheduleController@hours');

Route::middleware('auth:api')->group(function() {

    /*Route::get('/user', function(Request $request){
        return 'privado';
    });*/

    Route::get('/user', 'UserController@show');
    Route::post('/logout', 'AuthController@logout');

    // post appointment
    

});