<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if (isset($user->numExp)) {
            return;
        }

        $ramdomNum = $this->ramdomNum();
        $numExp = 'VLC-' . $ramdomNum;

        $password = $this->ramdomNum();
        Mail::to($email)->send(new SignUp($numExp, $password));

        return User::create([
            "name" => "", "surname" => "", "numExp" => $numExp, "password" => $password,
            "email" => $email, "address" => ""
        ]);
    }

    private function ramdomNum()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $ramdomNum[$i] = $alphabet[$n];
        }
        return implode("", $ramdomNum);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('numExp', 'password');
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
    public function forgotPass(Request $request)
    {
        $email = $request->input('email');
        $numExp = $request->input('numExpedient');
        $user = User::where(
            ['email', $email],
            ['numExp', $numExp]
        )->first();

        if (!isset($user->numExp)) {
            return;
        }
        $password = $this->ramdomNum();
        $user->password = $password;

        Mail::to($email)->send(new SignUp($numExp, $password));
        return $user::update();
    }
}