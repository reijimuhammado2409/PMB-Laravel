<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AgamaController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\ProvinsiController;
use App\Http\Controllers\Admin\KabupatenController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;

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
        
        Route::resource('provinsi', ProvinsiController::class)
        ->parameters(['provinsi' => 'provinsi']);
        Route::resource('kabupaten', KabupatenController::class)
        ->parameters(['kabupaten' => 'kabupaten']);
        Route::resource('kecamatan', KecamatanController::class)
        ->parameters(['kecamatan' => 'kecamatan']);

        // 🔹 Route tambahan untuk AJAX dropdown
        Route::get('/get-kabupaten/{provinsi_id}', [KecamatanController::class, 'getKabupatenByProvinsi'])
        ->name('kecamatan.getKabupatenByProvinsi');
                
        // CRUD Pendaftaran Mahasiswa
        Route::get('/pendaftaran', [MahasiswaController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/{id}/edit', [MahasiswaController::class, 'edit'])->name('pendaftaran.edit');
        Route::put('/pendaftaran/{id}', [MahasiswaController::class, 'update'])->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [MahasiswaController::class, 'destroy'])->name('pendaftaran.destroy');

        // Approve / Reject Mahasiswa
        Route::put('/pendaftaran/{id}/approve', [MahasiswaController::class, 'approve'])->name('pendaftaran.approve');
        Route::put('/pendaftaran/{id}/reject', [MahasiswaController::class, 'reject'])->name('pendaftaran.reject');
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
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa');

        // Form Pendaftaran Mahasiswa
        Route::get('/validasimahasiswa', [MahasiswaController::class, 'validasiMahasiswa'])->name('validasiAdmin');

        // Form create
        Route::get('/pendaftaran', [MahasiswaController::class, 'create'])->name('pendaftaran.create');

        // Store
        Route::post('/pendaftaran', [MahasiswaController::class, 'store'])->name('pendaftaran.store');

        // Cek Status Pendaftaran
        Route::get('/pendaftaran/status', [MahasiswaController::class, 'status'])->name('pendaftaran.status');

        // 🔹 Route tambahan untuk AJAX dropdown
        Route::get('/get-kabupaten/{provinsi_id}', [KecamatanController::class, 'getKabupatenByProvinsi'])
        ->name('kecamatan.getKabupatenByProvinsi');

        // 🔹 Route tambahan untuk AJAX dropdown
        Route::get('/get-kecamatan/{kabupaten_id}', [KecamatanController::class, 'getKecamatanByKabupaten'])
        ->name('kecamatan.getKecamatanByKabupaten');
    });
