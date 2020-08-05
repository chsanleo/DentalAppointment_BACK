<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::get('signup', 'AuthController@signup');
    Route::post('login', 'AuthController@login');
});
//CRUD User
Route::prefix('user')->group(function () {
    Route::get('{id}', 'UserController@getProfile');
    Route::post('', 'UserController@createUser');
    Route::put('{id}', 'UserController@updateUser');
    Route::delete('{id}', 'UserController@deleteUser');
});

//CRUD MEDICOS
Route::prefix('doctor')->group(function () {
    Route::get('{id}', 'DoctorController@getProfile');
    Route::post('', 'DoctorController@createDoctor');
    Route::put('{id}', 'DoctorController@updateDoctor');
    Route::delete('{id}', 'DoctorController@deleteDoctor');
});

//CITAS
Route::prefix('appointment')->group(function () {
    Route::get('', 'AppointmentController@getAll');
    Route::get('{id}', 'AppointmentController@get');
    Route::post('', 'AppointmentController@createAppointment');
    Route::put('{id}', 'AppointmentController@updateAppointment');
    Route::delete('{id}', 'AppointmentController@deleteAppointment');
});
