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
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// ========================
// Dashboard Route (multi-role)
// ========================
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user')->name('dashboard');

// ========================
// Notifications Routes
// ========================
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/notifications', function () {
        return view('pages.notifications');
    });

    Route::post('/notification/{id}/read', function ($id) {
        $notification = \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id);
        $notification->update(['read_at' => \Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP')]);
        $dataArray = json_decode($notification->firstOrFail()->data, true);
        return isset($dataArray['complaint_id']) ? redirect('/complaint') : back();
    });
});

// ========================
// Data Penduduk (Admin, Pengadministrasi Umum)
// ========================
Route::middleware(['role:Admin,Pengadministrasi Umum'])->group(function () {
    Route::resource('/resident', ResidentController::class)->except(['show']);
    Route::get('/account-list', [UserController::class, 'account_list_view']);
    Route::get('/account-request', [UserController::class, 'account_request_view']);
    Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// ========================
// Profil & Password Routes (semua role)
// ========================
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile_view'])->name('profile.view');
    Route::put('/profile/{userId}', [UserController::class, 'update_profile'])->name('profile.update');
    Route::get('/change-password', [UserController::class, 'change_password_view']); // typo diperbaiki
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

// ========================
// Disposisi Routes (KASI, Lurah, Sekretaris Lurah)
// ========================
Route::middleware(['role:KASI Pembangunan,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,Lurah,Sekretaris Lurah'])->group(function () {
    Route::get('/disposisi', [DisposisiController::class, 'index']);
});
Route::put('/profile/{userId}', [UserController::class, 'update_profile'])->name('profile.update');

