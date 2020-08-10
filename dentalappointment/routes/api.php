<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('signup', 'AuthController@signup');
    Route::post('login', 'AuthController@login');
    Route::post('forgot','AuthController@forgotPass');
});

//CRUD User
Route::prefix('user')->group(function () {
    Route::get('{id}', 'ClientController@getProfile');
    Route::post('', 'ClientController@updateUser');
    Route::delete('{id}', 'ClientController@deleteUser');
});

//CRUD MEDICOS
Route::prefix('doctor')->group(function () {
    Route::post('', 'DoctorController@createDoctor');
    Route::put('{id}', 'DoctorController@updateDoctor');
    Route::delete('{id}', 'DoctorController@deleteDoctor');
});

//CITAS
Route::prefix('appointment')->group(function () {
    Route::get('', 'AppointmentController@getAll');
    Route::get('choose', 'AppointmentController@getAllFree');
    Route::get('{id}', 'AppointmentController@get');
    Route::post('user', 'AppointmentController@getbyUser');
    Route::post('', 'AppointmentController@createAppointment');
    Route::post('update', 'AppointmentController@updateAppointment');
    Route::delete('{id}', 'AppointmentController@deleteAppointment');
});

//contact Mail
Route::prefix('contact')->group(function(){
    Route::get('','ContactMailController@getAll');
    Route::get('{id}','ContactMailController@get');
    Route::post('','ContactMailController@createContactMail');
    Route::get('update/{id}', 'AppointmentController@update');
});
