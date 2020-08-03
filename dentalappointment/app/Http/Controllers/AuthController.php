<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup()
    {
        $ramdomNum = $this->ramdomNum();
        $numExp = 'VLC-'.$ramdomNum;

        $user = new User;
        $user->numExp = $numExp;
        $user->password = $this->ramdomNum();

        //enviar mail
        return User::create($user);
    }

    private function ramdomNum(){
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, count($alphabet)-1);
        $ramdomNum[$i] = $alphabet[$n];
    }
    return $ramdomNum;
}
    

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Wrong credentials'], 400);
        }
        $user = Auth::user();
        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['token' => $token, 'user' => $user], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response([
            'mensaje' => 'User successfully logged out'
        ]);
    }
}