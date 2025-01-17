<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Laravel API'
    ]);
});

Route::middleware('auth:api')->group(function () {});
