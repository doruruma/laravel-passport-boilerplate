<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Laravel API'
    ]);
});

// authentication
Route::post('user/sign-in', [UserController::class, 'signIn']);

Route::middleware('auth:api')->group(function () {
    // refresh token
    Route::post('user/refresh-token', [UserController::class, 'refreshToken']);
});
