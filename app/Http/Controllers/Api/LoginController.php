<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('login_auth')->accessToken;

                return responseSuccess([
                    'user' => $user,
                    'token' => $token,
                ], 200, 'Login successful');
            } else {
                return responseError('Invalid credentials', 401);
            }
        } catch (\Exception $e) {
            return responseError('Login failed: ' . $e->getMessage(), 500);
        }
    }



    public function emailVerification()
    {
        $token = request()->query('token');
        if (!$token) {
            return responseError('Invalid Token', 404);
        }

        $passwordReset = DB::table('password_reset_tokens')
        ->where('token', $token)
        ->first();

    if (!$passwordReset) {
        return responseError('Token Not Found!', 404);
    }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return responseError('User Not Found!', 404);
        }

        $user->email_verified_at = now();
        $user->save();

        $passwordReset = DB::table('password_reset_tokens')
        ->where('token', $token)
        ->delete();
        return redirect(env("FRONTEND_URL") . "?success=Email verified successfully");

    }


}
