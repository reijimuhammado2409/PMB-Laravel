<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// halaman Default
Route::get('/', function () {
    return view('welcome');
});

// Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Change Password (hanya untuk user login)
Route::post('/change-password', [AuthController::class, 'changePassword'])
    ->middleware('auth')
    ->name('change.password');

// ✅ Tambahkan route tes ini untuk memastikan login tidak infinite loop
// Route::get('/admin-test', function() {
//     return 'Halo Admin, login berhasil!';
// })->middleware('auth');

// Route::get('/mahasiswa-test', function() {
//     return 'Halo Mahasiswa, login berhasil!';
// })->middleware('auth');

// Dashboard untuk Admin
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

Route::get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswa'])
    ->middleware(['auth', 'mahasiswa'])
    ->name('mahasiswa.dashboard');