<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RentCarController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "/a1"], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register', [UserController::class, 'index'])->middleware(['auth:sanctum','checkRole:1']);

    Route::apiResource('/rent', RentController::class)->middleware(['auth:sanctum']);
    Route::apiResource('/rent-cars', RentCarController::class)->middleware(['auth:sanctum']);


    Route::group(["prefix" => "/auth"], function(){
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

        Route::get('/user', [UserController::class, 'user'])->middleware(['auth:sanctum']);
        
        Route::get('/error', function(){
            return response()->json([
                "message" => "Forbidden"
            ], 403);
        })->name('forbidden');

    });
});
