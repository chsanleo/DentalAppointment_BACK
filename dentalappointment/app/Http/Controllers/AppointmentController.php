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
            'startTime', '>', Carbon::now()->subWeek(1)
        )->get();
    }

    //Route::get('{id}', 'AppointmentController@get');
    public function get($id)
    {
        return Appointment::find($id);
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
        $appointment = Appointment::create($body);
        return response()->json($appointment, 201);
    }

    //Route::put('{id}', 'AppointmentController@updateAppointment');
    public function updateAppointment(Request $request, $id)
    {
        $body = $request->all();
        $validator = $this->appointmentValidator($body);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'There was a problem, contact with administrator.',
                'errors' => $validator->errors()
            ], 400);
        }
        $appointment = Appointment::find($id);
        $appointment->update($body);
        return $appointment;
    }

    //Route::delete('{id}', 'AppointmentController@deleteAppointment');
    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();
        return response()->json(['message'=>'Appointment deleted']);
    }

    private function appointmentValidator($body){
        return Validator::make($body, [
            'numExp' => 'required|string',
            'user_id' => 'required|integer',
            'startTime' => 'required|',//
            'endTime' => 'required|after:startTime'//
        ]);
    }
}
