<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response('Loggedout', 200);
    }
    public function signUp(Request $request)
    {
        $data = $request->data;
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];
        $type = $data['type'];
        $password = Hash::make($data['password']);
        $checkEmail = User::where('email', $email)->first();
        if (!empty($checkEmail)) {
            return response()->json(['message' => 'This email is already taken!']);
        } else {
            //register user
            $User = new User;
            $User->email = $email;
            $User->name = $username;
            $User->password = $password;
            $User->type = $type;
            $User->save();
            return response()->json(['message' => 'Successfully Registered.']);
        }
    }
}
