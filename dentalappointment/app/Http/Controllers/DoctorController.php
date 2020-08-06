<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    //Route::get('{id}', 'DoctorController@getProfile');
    public function getProfile($id)
    {
        return User::where(
            ['id', $id],
            ['type', 'doctor']
        );
    }
    //Route::post('', 'DoctorController@createDoctor');
    public function createDoctor(Request $request, $id)
    {
        $request->type = 'doctor';
        $body = $request->all();
        $validator = $this->doctorValidator($body);

        if ($validator->fails()) {
            return response()->json(['message' => 'There was a problem trying to update the user'], 400);
        }

        return User::create($body);
    }
    //Route::put('{id}', 'DoctorController@updateDoctor');
    public function updateDoctor(Request $request, $id)
    {
        $request->type = 'doctor';
        $body = $request->all();
        $validator = $this->doctorValidator($body);
        if ($validator->fails()) {
            return response()->json(['message' => 'There was a problem trying to update the user'], 400);
        }
        $user = User::find($id);
        return $user->update($body);
    }
    //Route::delete('{id}', 'DoctorController@deleteDoctor');
    public function deleteDoctor($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'Doctor deleted']);
    }

    private function doctorValidator($body)
    {
        return Validator::make($body, [
            'name' => 'required|string',
            'address' => 'string|max:255',
            'numExp' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
    }
}
