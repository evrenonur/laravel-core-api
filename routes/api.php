<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'v1',
        'middleware' => ['api'],
    ],
    function () {
        Route::post('/auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    }
);

Route::group(
    [
        'prefix' => 'v1',
        'middleware' => ['auth:sanctum', 'api'],
    ],
    function () {
        Route::get('/me',function (Request $request){
            return $request->user();
        })->middleware('checkRole:user,admin');
        Route::post('/auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('checkRole:user,admin');

    }
);
