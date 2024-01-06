<?php

use App\Http\Controllers\Api\HostelBookingController;
use App\Http\Controllers\Api\HostelController;
use App\Http\Controllers\Api\HostelFeatureController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'hostels'], function () {
        Route::apiResource('/', HostelController::class)->parameters(["" => 'slug']);
    });

    Route::apiResource('rooms', RoomController::class)->parameters(["rooms" => 'id']);

    Route::post('user/status/update',[UserController::class, 'updateStatus']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::get('user/{id}', [UserController::class, 'show']);

    Route::post('hostel-booking',[HostelBookingController::class,'store']);
    Route::get('hostel-booking', [HostelBookingController::class, 'index']);

    Route::apiResource('hostel-features', HostelFeatureController::class)->parameters(["hostel-features"=>"id"]);

});
