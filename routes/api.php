<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

//open routes

Route::group([
    "middleware"=>['auth:api']]
,function(){
    Route::get('profile',[AuthController::class,'profile']);
    Route::get('logout',[AuthController::class,'logout']);
    Route::post('store',[TaskController::class,'store']);
    Route::post('assigntask/{taskid}',[TaskController::class,'assigntask']);
    Route::post('unassigntask/{taskid}',[TaskController::class,'unassigntask']);
    Route::get('getauthusertask',[TaskController::class,'getauthusertask']);
    Route::get('usertask/{id}',[TaskController::class,'usertask']);
    
    
});
//protected routes