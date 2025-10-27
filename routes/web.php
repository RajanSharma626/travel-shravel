<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'check.active'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');



    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // users routes restricted to admin only
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/user/store', [UserController::class, 'store'])->name('userss.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/user/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
    });
});
