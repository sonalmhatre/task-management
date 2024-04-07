<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

//open routes
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

//protected routes

Route::group([
    "middleware"=>['auth:api']]
,function(){
    Route::get('profile',[AuthController::class,'profile']);
    Route::get('logout',[AuthController::class,'logout']);

    //
    Route::prefix('task')->group(function () {
        Route::get('/',[TaskController::class,'index']);
        Route::post('store',[TaskController::class,'store']);
        Route::post('update/{id}',[TaskController::class,'update']);
        Route::post('delete/{id}',[TaskController::class,'delete']);

        Route::post('assign/{taskid}',[TaskController::class,'assigntask']);
        Route::post('unassign/{taskid}',[TaskController::class,'unassigntask']);
        Route::post('changestatus/{taskid}',[TaskController::class,'changetaskstatus']);
        
        Route::get('getauthuser',[TaskController::class,'getauthusertask']);
        Route::get('user/{id}',[TaskController::class,'usertask']);
    });
    
    
});
//protected routes