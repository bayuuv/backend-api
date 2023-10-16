<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::match(['GET', 'POST'], '/login', "App\Http\Controllers\Api\LoginController@index")->name('login');

//Route::post('login', [App\Http\Controllers\Api\LoginController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::apiResource('posts', App\Http\Controllers\Api\PostController::class);
});
