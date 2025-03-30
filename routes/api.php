<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('me', [AuthController::class, 'me'])->name('me');

Route::middleware('jwt.auth')->group(function () {
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('logout', [AuthController::class, 'logout']);
});

if (app()->environment('local')) {
    Route::post('testlogin/{id}', function ($id) {
        Auth::onceUsingId($id);
        return auth()->tokenById(auth()->user()->id);
    });
}

