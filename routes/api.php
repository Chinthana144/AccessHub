<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\CodeResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/testAPI', function(){
        return response()->json([
            'success' => true,
            'message' => 'working'
        ]);
    });

    Route::get('/getIdentity', [CodeResetController::class, 'getIdentity']);

    Route::get('/getOneUser', [CodeResetController::class, 'getOneUser']);
    Route::get('/resetCode', [CodeResetController::class, 'resetCode']);
    Route::get('/disableUser', [CodeResetController::class, 'disableUser']);
    Route::get('/enableUser', [CodeResetController::class, 'enableUser']);

    Route::get('/getSessionByUsername', [CodeResetController::class, "getSessionByUsername"]);

});//middleware auth
