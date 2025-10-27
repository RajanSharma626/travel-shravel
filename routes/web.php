<?php

use App\Http\Controllers\AuthController;
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

 });