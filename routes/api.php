<?php

use App\Http\Controllers\TestController;
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

Route::get('/test', [TestController::class, 'index']);
Route::post('/test', [TestController::class, 'store']);

Route::get('/echo', [TestController::class, 'echoGet']);
Route::post('/echo', [TestController::class, 'echoPost']);

Route::get('/ping', [TestController::class, 'pingGet']);
Route::post('/ping', [TestController::class, 'pingPost']);


