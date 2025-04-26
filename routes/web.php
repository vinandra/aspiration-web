<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,User');

Route::get('/resident', [ResidentController::class, 'index'])->middleware('role:Admin');
Route::get('/resident/create', [ResidentController::class, 'create'])->middleware('role:Admin');
Route::get('/resident/{id}', [ResidentController::class, 'edit'])->middleware('role:Admin');
Route::post('/resident', [ResidentController::class, 'store'])->middleware('role:Admin');
Route::put('/resident/{id}', [ResidentController::class, 'update'])->middleware('role:Admin');
Route::delete('/resident/{id}', [ResidentController::class, 'destroy'])->middleware('role:Admin');

Route::get('/account-request', [UserController::class,'account_request_view']);
Route::post('/account-request/approval/{id}', [UserController::class,'account_approval']);