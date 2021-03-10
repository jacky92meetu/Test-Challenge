<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;

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

Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');

Route::group(['middleware' => ['json.response']], function () {
    
    Route::get('/', function (Request $request) {
        return response()->json(['message' => 'Only support API call'], 200);
        exit;
    });

    Route::get('login', function(Request $request){
        return response()->json(['message' => 'Unauthorized'], 401);
    })->name('login');

    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::post('reset_token', [AuthController::class, 'reset_token']);

        Route::apiResource('users', UserController::class);
        Route::apiResource('posts', PostController::class);
    });

});

