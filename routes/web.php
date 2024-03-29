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
    return redirect('/login'); // return view('welcome');
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

  Route::get('/charts/appointments/line', 'ChartController@appointments');
  Route::get('/charts/doctors/column', 'ChartController@doctors');
  Route::get('/charts/doctors/column/data', 'ChartController@doctorsJson');
});


Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function() {
  //schedule
  Route::get('/schedule', 'ScheduleController@edit');
  Route::post('/schedule', 'ScheduleController@store');
});

Route::middleware('auth')->group(function() {
  Route::get('/profile', 'UserController@edit');
  Route::post('/profile', 'UserController@update');  

  Route::middleware('phone')->group(function() {
    Route::get('/appointments', 'AppointmentController@index');
    Route::get('/appointments/create', 'AppointmentController@create');
  });

  Route::get('/appointments/{appointment}', 'AppointmentController@show');  //ver cita
  Route::post('/appointments', 'AppointmentController@store');  //procesar formulario

  Route::get('/appointments/{appointment}/cancel', 'AppointmentController@showCancelForm');
  Route::post('/appointments/{appointment}/cancel', 'AppointmentController@postCancel');
  Route::post('/appointments/{appointment}/confirm', 'AppointmentController@postConfirm');



  //JSON pasaron a ser recursos publicos
  /*Route::get('/specialties/{specialty}/doctors', 'Api\SpecialtyController@doctors');
  Route::get('/schedule/hours', 'Api\ScheduleController@hours');*/
});
