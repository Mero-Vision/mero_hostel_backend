<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\UserVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        try{

            $user=DB::transaction(function() use($request){

                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'status'=>$request->status

                ]);
                if ($request->status == 'Hostel_Owner') {
                    $user->assignRole('Hostel_Owner');
                } elseif ($request->status == 'Hostel_Searcher') {
                    $user->assignRole('Hostel_Searcher');
                }


                return $user;

            });
            if ($user) {
                $token = Str::random(60);

                DB::table('password_reset_tokens')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);


                Mail::to($request->input('email'))->send(new UserVerificationMail($user,$token));
                return responseSuccess([
                    'data' => $user,
                    'token' => $token,
                ], 201, 'User account created successfully!');
            }

        }
        catch(\Exception $e){
            return responseError($e->getMessage(),500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
