<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\JurusanController;


/*
|--------------------------------------------------------------------------
| Halaman Default
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/change-password', [AuthController::class, 'changePassword'])
    ->middleware('auth')
    ->name('change.password');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // Master Data
        Route::resource('agama', AgamaController::class);
        Route::resource('fakultas', FakultasController::class)
        ->parameters(['fakultas' => 'fakultas']);
        Route::resource('jurusan', JurusanController::class)
        ->parameters(['jurusan' => 'jurusan']);


        
        // nanti tinggal tambahin fakultas, jurusan, provinsi, kabupaten, kecamatan, dst.
    });

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');

        // nanti bisa tambahkan route untuk pendaftaran, pembayaran, dll
    });
