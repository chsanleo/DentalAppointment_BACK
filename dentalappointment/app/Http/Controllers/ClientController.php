<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    //Route::get('{id}', 'UserController@getProfile');
    public function getProfile($id)
    {
        return User::where('id', $id);
    }

    //Route::put('{id}', 'UserController@updateUser');
    public function updateUser(Request $request)
    {
        $body = $request->all();
        $validator = Validator::make($body, [
            'name' => 'required|string',
            'surname' => 'required|string',
            'address' => 'string|max:255',
            'numExp' => 'required|string',
            'email' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'There was a problem trying to update the user'], 400);
        }
        $user = User::where('numExp', $request->input('numExp'));

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->address = $request->input('address');
        $user->email = $request->input('email');

        return $user->save();
    }

    //Route::delete('{id}', 'UserController@deleteUser');
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
