<?php

use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/email-verified',[LoginController::class,'emailVerification']);

Route::get('/forgot-password',[ForgotPasswordController::class,'forgotpassword']);
Route::post('/reset-password',[ForgotPasswordController::class,'resetPassword']);


