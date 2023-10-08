<?php

use App\Http\Controllers\Api\HostelController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware'=>'auth:api'],function(){

    Route::group(['prefix'=>'hostels'],function(){
        Route::apiResource('/',HostelController::class);

    });



});
