<?php

namespace App\Http\Controllers;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //Route::get('', 'AppointmentController@getAll');
    public function getAll()
    {
        return Appointment::where(
            'startTime',
            '>',
            Carbon::now()->subWeek(1)
        )->get();
    }

    //Route::get('choose', 'AppointmentController@getAllFree');
    public function getAllFree()
    {
        return Appointment::where(
            [
                ['startTime', '>', Carbon::now()->subWeek(1)],
                ['numExp', '']
            ]
        )->get();
    }

    //Route::get('{id}', 'AppointmentController@get');
    public function get($id)
    {
        return Appointment::find($id);
    }

    //Route::post('user', 'AppointmentController@getbyUser');
    public function getbyUser(Request $request)
    { 
        $numExp = $request->input('numExp');
        return Appointment::where('numExp', $numExp)->first();
    }

    //Route::post('', 'AppointmentController@createAppointment');
    public function createAppointment(Request $request)
    {
        $body = $request->all();
        $validator = $this->appointmentValidator($body);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'There was a problem, contact with administrator.',
                'errors' => $validator->errors()
            ], 400);
        }

        $user_id = $request->input('user_id');
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');
        
        $appointment = Appointment::create([
            "numExp" => "", "subject" => "", "user_id" => $user_id,
            "startTime" => $startTime, "endTime" => $endTime
        ]);
        return response()->json($appointment, 201);
    }

    //Route::put('update', 'AppointmentController@updateAppointment');
    public function updateAppointment(Request $request)
    {
        $body = $request->all();

        $validator = $this->appointmentValidator($body);

        $validatorUpdate = Validator::make($body, [
            'numExp' => 'required|string',
            'subject' => 'required|string'
        ]);

        if (/*$validator->fails() || */$validatorUpdate->fails()) {
            return response()->json([
                'message' => 'There was a problem, contact with administrator.',
                'errors' => $validator->errors()
            ], 400);
        }
        $appointment = Appointment::find($request->input('id'));

        $appointment->numExp = $request->input('numExp');
        $appointment->subject = $request->input('subject');

        $appointment->save();
        return $appointment;
    }

    //Route::delete('{id}', 'AppointmentController@deleteAppointment');
    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted']);
    }

    private function appointmentValidator($body)
    {
        return Validator::make($body, [
            'user_id' => 'required|integer', //who create
            'startTime' => 'required|date_format:Y-m-d H:i:s', //
            'endTime' => 'required|after:startTime|date_format:Y-m-d H:i:s' //
        ]);
    }
}
