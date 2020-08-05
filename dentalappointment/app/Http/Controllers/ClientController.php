<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    //Route::get('{id}', 'UserController@getProfile');
    public function getProfile($id)
    {
        return User::find($id);
    }

    //Route::put('{id}', 'UserController@updateUser');
    public function updateUser(Request $request, $id)
    {
        $body = $request->all();
        $validator = Validator::make($body,[
            'name' => 'required|string',
            'address' => 'string|max:255',
            'numExp' => 'required|string',
            'email'=> 'required|string',
            'password' => 'required|string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'There was a problem trying to update the user'], 400);
        }
        $user = User::find($id);
        return $user->update($body);
    }

    //Route::delete('{id}', 'UserController@deleteUser');
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
