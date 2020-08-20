<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequestClient;
use App\Notifications\PasswordResetSuccessClient;
use App\User;
use App\PasswordReset;
use Illuminate\Support\Str;

class PasswordClientController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                'message' => "The entered email address does not match our records. Please check your email and try again!"
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(

            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60)
            ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequestClient($passwordReset->token)
            );
        return response()->json([
            'message' => 'The password reset link has been sent to your Email successfully!'
        ]);
    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find(Request $request)
    {

        $passwordReset = PasswordReset::where('token', $request->token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token or the email that you re-entered is invalid. Please check and try again!'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid or has been expired.'
            ], 404);
        }
        return response()->json($passwordReset,200, [], JSON_NUMERIC_CHECK);
    }
    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccessClient($passwordReset));
        return response()->json(['message' => 'success'], 200);
    }
}
