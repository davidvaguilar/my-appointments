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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');    //{{ route('home') }}


Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function() {
  //Specialty
  Route::get('/specialties', 'SpecialtyController@index');
  Route::get('/specialties/create', 'SpecialtyController@create'); //form registro
  Route::get('/specialties/{specialty}/edit', 'SpecialtyController@edit');
  Route::post('/specialties', 'SpecialtyController@store'); //envio form
  Route::put('/specialties/{specialty}', 'SpecialtyController@update');
  Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy');
  //doctors
  Route::resource('/doctors', 'DoctorController');
  //pacients
  Route::resource('/patients', 'PatientController');
});


Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function() {
  //schedule
  Route::get('/schedule', 'ScheduleController@edit');
  Route::post('/schedule', 'ScheduleController@store');
});

Route::middleware('auth')->group(function() {
  Route::get('/appointments/create', 'AppointmentController@create');
  Route::get('/appointments', 'AppointmentController@store');

  //JSON
  Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
  Route::get('/schedule/hours', 'Api\ScheduleController@hours');
});
