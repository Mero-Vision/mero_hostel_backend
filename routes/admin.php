<?php

use App\Http\Controllers\Api\HostelController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'hostels'], function () {
        Route::apiResource('/', HostelController::class)->parameters(["" => 'slug']);
    });

    Route::apiResource('rooms', RoomController::class)->parameters(["rooms" => 'id']);

    Route::post('user/status/update',[UserController::class, 'updateStatus']);
});