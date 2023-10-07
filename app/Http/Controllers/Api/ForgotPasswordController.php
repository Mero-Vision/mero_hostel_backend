<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class ForgotPasswordController extends Controller
{

    public function sendForgotPasswordMail(ForgotPasswordRequest $request)
    {

        try {
            $email = $request->email;
            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            $forgorPassword = DB::transaction(function () use ($request, $email) {
                $token = Str::random(20);

                $forgorPassword = DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);

                Mail::to($request->email)->send(new ForgotPasswordMail($email, $token));
                return $forgorPassword;
            });
            if ($forgorPassword) {
                return responseSuccess($forgorPassword, 200, 'Email has been send successfully!');
            }
        } catch (\Exception $e) {
            return responseError($e->getMessage(), 500);
        }
    }
    public function forgotpassword()
    {
        return view('/forgot-password');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        try {

            $token = $request->token;

            $validateToken = DB::table('password_reset_tokens')
                ->where('token', $token)->first();
            if (!$validateToken) {
                return back()->with('error', 'Token does not match or already deleted!');
            }
            $user = User::where('email', $validateToken->email)->first();
            if (!$user) {
                return back()->with('error', 'User does not found!');
            }
            $user->password = Hash::make($request->password);
            $user->save();
            $passwordReset = DB::table('password_reset_tokens')
                ->where('token', $token)
                ->delete();

            return redirect('/forgot-password')->with('success', 'Your password has been changed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
