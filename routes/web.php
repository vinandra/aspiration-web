<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisposisiController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ============================
// Authentication Routes
// ============================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// ============================
// Dashboard Route
// ============================
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware('role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user')
  ->name('dashboard');

// ============================
// Notification Routes
// ============================
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/notifications', function () {
        return view('pages.notifications');
    });

    Route::post('/notification/{id}/read', function ($id) {
        $notification = DB::table('notifications')->where('id', $id);
        $notification->update(['read_at' => DB::raw('CURRENT_TIMESTAMP')]);

        $dataArray = json_decode($notification->firstOrFail()->data, true);
        return isset($dataArray['complaint_id']) ? redirect('/complaint') : back();
    });
});

// ============================
// Admin & Staff Routes
// ============================
Route::middleware(['role:Admin,Pengadministrasi Umum'])->group(function () {
    Route::resource('/resident', ResidentController::class)->except(['show']);
    Route::get('/account-list', [UserController::class, 'account_list_view']);
    Route::get('/account-request', [UserController::class, 'account_request_view']);
    Route::post('/account-request/approval/{id}', [UserController::class, 'account_approval']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// ============================
// Profile & Password (All Roles)
// ============================
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile_view'])->name('profile.view');
    Route::put('/profile/{userId}', [UserController::class, 'update_profile'])->name('profile.update');
    Route::get('/change-password', [UserController::class, 'change_password_view']);
    Route::post('/change-password/{id}', [UserController::class, 'change_password']);
});

// ============================
// Complaint / Aspirasi Warga
// ============================

// Route resource untuk semua method (user only)
Route::middleware(['role:user'])->group(function () {
    Route::resource('/complaint', ComplaintController::class);
});

// Index bisa diakses semua role
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,user'])->group(function () {
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
});

// Admin dan pejabat lainnya bisa update status dan forward
Route::middleware(['role:Admin,Pengadministrasi Umum,KASI Pembangunan,Sekretaris Lurah,Lurah,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman'])->group(function () {
    Route::post('/complaint/update-status/{id}', [ComplaintController::class, 'update_status']);
    Route::post('/complaint/forward/{id}', [ComplaintController::class, 'forward'])->name('complaint.forward');
});

// ============================
// Disposisi Routes
// ============================
Route::middleware(['role:KASI Pembangunan,KASI Kesejahteraan Sosial,KASI Pemerintahan Ketentraman,Lurah,Sekretaris Lurah'])->group(function () {
    Route::get('/disposisi', [DisposisiController::class, 'index']);
});
