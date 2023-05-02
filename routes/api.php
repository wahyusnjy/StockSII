<?php

use App\Http\Controllers\Api\ApiProductController ;
use App\Http\Controllers\Api\AuthAPIController ;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthAPIController::class, 'login'])->name('login');
Route::post('/logout', [AuthAPIController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-user', [AuthAPIController::class, 'userInfo']);

    Route::get('/products',[ApiProductController::class,'index']);
    Route::post('/products/store',[ApiProductController::class,'store']);
    Route::post('/products/update/{id}',[ApiProductController::class,'update']);
    Route::delete('/products/delete/{id}',[ApiProductController::class,'index']);
});
