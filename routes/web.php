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
use App\Http\Controllers\UserController;
use App\Http\Controllers\MultipleuploadsController;

// ===========================================
// RUTE TANPA AUTENTIKASI (GUEST)
// ===========================================
Route::middleware('guest')->group(function () {
    // Rute default halaman utama (Welcome)
    Route::get('/', function () {
        return view('welcome');
    });

    // Halaman Form Login (menggantikan route auth.index yang lama)
    Route::get('/auth', [AuthController::class, 'index'])->name('login');

    // Proses Submit Login (menggantikan route auth.login yang lama)
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login.process');

    // --- Rute PCR Original (Bebas Akses) ---
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

    // Matakuliah
    Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah');
    Route::get('/matakuliah/show/{kode?}', [MatakuliahController::class, 'show']);

    // Pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
});


// ===========================================
// RUTE MEMERLUKAN AUTENTIKASI (AUTH)
// ===========================================
Route::middleware('auth')->group(function () {

    // Logout (Bisa diakses semua user yang login)
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');

    // -- DASHBOARD & Rute User Biasa --
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home'); // Rute home yang butuh auth

    // Fitur User Biasa (Contoh: Kirim Pertanyaan)
    Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');

    // Rute Resource yang dipindahkan ke dalam group admin (User & Pelanggan)
    // Route::resource('pelanggan', PelangganController::class); // Dihapus karena akan masuk di group admin
    // Route::resource('user', UserController::class); // Dihapus karena akan masuk di group admin

    // ===========================================
    // RUTE KHUSUS ADMIN (ROLE:ADMIN)
    // ===========================================
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Manajemen User
        Route::resource('user', UserController::class);

        // Manajemen Pelanggan
        Route::resource('pelanggan', PelangganController::class);
    });

    Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])->name('uploads');
    Route::post('/save', [MultipleuploadsController::class, 'store'])->name('uploads.store');

    // ⬇️ Ini route baru yang benar (ditambahkan sesuai request)
    Route::post('/multipleuploads/store-for-ref', [MultipleuploadsController::class, 'storeForRef'])
        ->name('multipleuploads.storeForRef');

    Route::post('/uploads/ref', [MultipleuploadsController::class, 'storeForRef'])->name('uploads.store.ref');
    Route::delete('/uploads/{id}', [MultipleuploadsController::class, 'destroy'])->name('uploads.destroy');

    Route::get('/pelanggan/{id}/detail', [PelangganController::class, 'show'])->name('pelanggan.detail');
    Route::get('/test-write', function() {
        $path = public_path('images/test.txt');
        try {
            file_put_contents($path, "Hello");
            return "Write OK";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    });

});
