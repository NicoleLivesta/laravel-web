<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;

Route::get('/', function () {
    return view ('welcome');

});

Route::get('/pcr', function () {
    return 'selamat datang di website kampus PCR!';
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/nama/{param1}', function ($param1) {
    return 'nama saya: '.$param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'nim saya: '.$param1;
});

Route::get('/about', function () {
    return view('halaman-about');
});

//matakuliah
Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah');
Route::get('/matakuliah/show/{kode?}', [MatakuliahController::class, 'show']);

//home
Route::get('/home', [HomeController::class, 'index'])->name('home');

//question
Route::post('question/store', [QuestionController::class, 'store'])
		->name('question.store');

//auth
Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

//pegawai
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//pelanggan
Route::resource('pelanggan', PelangganController::class);
