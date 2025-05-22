<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// ========================
// Authentication Routes
// ========================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================
// New routes for resident registration
// ========================
Route::get('/register-resident', [AuthController::class, 'registerResidentView'])->name('register.resident');
Route::post('/register-resident', [AuthController::class, 'registerResident'])->name('register.resident.post');

Route::get('/register-account/{resident_id}', [AuthController::class, 'registerAccountView'])->name('register.account');
Route::post('/register-account/{resident_id}', [AuthController::class, 'registerAccount'])->name('register.account.post');


Route::get('/aspirasi', [App\Http\Controllers\AspirasiTampungController::class, 'index'])->name('aspirasi.form');
Route::post('/aspirasi', [App\Http\Controllers\AspirasiTampungController::class, 'store'])->name('aspirasi.store');
// ========================
// Dashboard Route (multi-role)
// ========================
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user')->name('dashboard');

// ========================
// Data Penduduk (Admin, Pengadministrasi Umum)
// ========================
Route::middleware(['role:Admin,Pengadministrasi Umum'])->group(function () {
    Route::resource('/resident', ResidentController::class)->except(['show']);
});

// ========================
// Profil & Password Routes (semua role)
// ========================
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile_view'])->name('profile.view');
    Route::put('/profile/{userId}', [UserController::class, 'update_profile'])->name('profile.update');
    Route::get('/change-password', [UserController::class, 'change_password_view']);
    Route::post('/change-password/{id}', [UserController::class, 'change_password']);
});

// ========================
// Complaint / Aspirasi Warga Routes
// ========================
Route::middleware(['role:user'])->group(function () {
    Route::resource('/complaint', ComplaintController::class)->only(['create', 'edit', 'store', 'update', 'destroy']);
});
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/complaint', [ComplaintController::class, 'index']);
});
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman'])->group(function () {
    Route::post('/complaint/update-status/{id}', [ComplaintController::class, 'update_status']);
    Route::post('/complaint/forward/{id}', [ComplaintController::class, 'forward'])->name('complaint.forward');
});

// Complaint Publish/Unpublish Routes (Admin only)
Route::middleware(['role:Admin'])->group(function () {
    Route::post('/complaint/{id}/publish', [ComplaintController::class, 'publish'])->name('complaint.publish');
    Route::post('/complaint/{id}/unpublish', [ComplaintController::class, 'unpublish'])->name('complaint.unpublish');
});