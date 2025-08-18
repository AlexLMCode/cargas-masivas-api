<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        //Auth Routes
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');
    });

    # Auth Middleware Routes
    Route::middleware(['auth:api'])->group(function () {
        Route::get('logout', 'logout')->name('logout');
        Route::get('profile', 'userProfile')->name('profile');
        Route::get('personas', [PersonaController::class, 'personas'])->name('personas');
        Route::post('load', [PersonaController::class, 'load'])->name('load')->middleware('permission:upload personas');
        Route::get('personas/{id}', [PersonaController::class, 'persona'])->name('persona')->middleware('permission:show detalle persona');
    });
});
