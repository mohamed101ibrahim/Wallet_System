<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::post('/user/login', [AuthController::class, 'userLogin']);
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
    Route::middleware('auth.api')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

});