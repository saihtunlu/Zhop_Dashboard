<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Permission_User;
use App\PermissionProduct;
use App\PermissionInvoice;
use App\Role;
use App\User_Role;

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
        $password = Hash::make($data['password']);
        $checkEmail = User::where('email', $email)->first();
        if (!empty($checkEmail)) {
            return response()->json(['message' => 'This email is already taken!'], 422);
        } else {
            //register user
            $User = new User;
            $User->email = $email;
            $User->name = $username;
            $User->password = $password;
            $User->save();

            $Role = Role::where('name', 'Customer')->first();
            $User_Role = new User_Role;
            $User_Role->user_id = $User->id;
            $User_Role->role_id = $Role->id;
            $User_Role->save();
            //user_permission
            $Permission_User = new Permission_User;
            $Permission_User->name = 'User';
            $Permission_User->create = 0;
            $Permission_User->update = 0;
            $Permission_User->read = 0;
            $Permission_User->delete = 0;
            $Permission_User->user_id = $User->id;
            $Permission_User->save();
            //user_permission
            $PermissionProduct = new PermissionProduct;
            $PermissionProduct->name = 'Product';
            $PermissionProduct->create = 0;
            $PermissionProduct->update = 0;
            $PermissionProduct->read = 0;
            $PermissionProduct->delete = 0;
            $PermissionProduct->user_id = $User->id;
            $PermissionProduct->save();
            //invoice_permission
            $PermissionInvoice = new PermissionInvoice;
            $PermissionInvoice->name = 'Invoice';
            $PermissionInvoice->create = 0;
            $PermissionInvoice->update = 0;
            $PermissionInvoice->read = 0;
            $PermissionInvoice->delete = 0;
            $PermissionInvoice->user_id = $User->id;
            $PermissionInvoice->save();

            return response()->json(['message' => 'Successfully Registered.']);
        }
    }
}
