<?php

namespace App\Http\Controllers;

use App\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactMailController extends Controller
{
    //Route::get('','ContactMailController@getAll');
    public function getAll()
    {
        return ContactMail::get();
    }
    //Route::get('{id}','ContactMailController@get');
    public function get($id)
    {
        return ContactMail::find($id);
    }

    //Route::post('','ContactMailController@createContactMail');
    public function createContactMail(Request $request, $id)
    {
        $body = $request->all();
        $body['user_id'] = Auth::id();
        $validator = Validator::make($request->all(), [
            'contactMail' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'There was a problem trying to update the user'], 400);
        }
        
        return ContactMail::create($body);
    }

    //Route::get('{id}', 'AppointmentController@update');
    public function update($id)
    {
        $contactMail = ContactMail::find($id);
        $contactMail->processed = true;
        return $contactMail->update($contactMail);
    }
}
