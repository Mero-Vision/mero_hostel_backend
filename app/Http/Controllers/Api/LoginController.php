<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}
