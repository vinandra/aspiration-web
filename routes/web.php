<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
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

Route::get('/account-list', [UserController::class, 'account_list_view'])->middleware('role:Admin');

Route::get('/account-request', [UserController::class,'account_request_view'])->middleware('role:Admin');
Route::post('/account-request/approval/{id}', [UserController::class,'account_approval'])->middleware('role:Admin');

Route::get('/profile', [UserController::class, 'profile_view'])->middleware('role:Admin,User');
Route::post('/profile/{id}', [UserController::class, 'update_profile'])->middleware('role:Admin,User');
Route::get('/change-password', [UserController::class, 'chage_password_view'])->middleware('role:Admin,User');
Route::post('/change-password/{id}', [UserController::class, 'change_password'])->middleware('role:Admin,User');

Route::get('/complaint', [ComplaintController::class, 'index'])->middleware('role:Admin,User');
Route::get('/complaint/create', [ComplaintController::class, 'create'])->middleware('role:User');
Route::get('/complaint/{id}', [ComplaintController::class, 'edit'])->middleware('role:User');
Route::post('/complaint', [ComplaintController::class, 'store'])->middleware('role:User');
Route::put('/complaint/{id}', [ComplaintController::class, 'update'])->middleware('role:User');
Route::delete('/complaint/{id}', [ComplaintController::class, 'destroy'])->middleware('role:User');
Route::post('/complaint/update-status/{id}', [ComplaintController::class, 'update_status'])->middleware('role:Admin');