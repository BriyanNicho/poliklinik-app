<?php

use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PoliController;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            default => redirect()->route('pasien.dashboard'),
        };
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalPoli' => Poli::count(),
            'totalDokter' => User::where('role', 'dokter')->count(),
            'totalPasien' => User::where('role', 'pasien')->count(),
            'totalObat' => Obat::count(),
            'totalPendaftaran' => DaftarPoli::count(),
            'totalPemeriksaan' => Periksa::count(),
        ]);
    })->name('admin.dashboard');
    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        $dokterId = auth()->id();
        $jadwalIds = JadwalPeriksa::where('id_dokter', $dokterId)->pluck('id');

        return view('dokter.dashboard', [
            'totalJadwal' => $jadwalIds->count(),
            'totalPasien' => DaftarPoli::whereIn('id_jadwal', $jadwalIds)
                ->distinct('id_pasien')
                ->count('id_pasien'),
            'totalMenunggu' => DaftarPoli::whereIn('id_jadwal', $jadwalIds)
                ->whereDoesntHave('periksa')
                ->count(),
            'totalSelesai' => DaftarPoli::whereIn('id_jadwal', $jadwalIds)
                ->whereHas('periksa')
                ->count(),
            'pasienMenunggu' => DaftarPoli::with(['pasien', 'jadwalPeriksa'])
                ->whereIn('id_jadwal', $jadwalIds)
                ->whereDoesntHave('periksa')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    })->name('dokter.dashboard');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');
    Route::get('/periksa-pasien/{id}/edit', [PeriksaPasienController::class, 'edit'])->name('periksa-pasien.edit');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', function () {
        $pendaftaran = DaftarPoli::with(['jadwalPeriksa.dokter'])
            ->where('id_pasien', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('pasien.dashboard', [
            'totalPendaftaran' => DaftarPoli::where('id_pasien', auth()->id())->count(),
            'totalMenunggu' => DaftarPoli::where('id_pasien', auth()->id())
                ->whereDoesntHave('periksa')
                ->count(),
            'totalSelesai' => DaftarPoli::where('id_pasien', auth()->id())
                ->whereHas('periksa')
                ->count(),
            'pendaftaran' => $pendaftaran,
        ]);
    })->name('dashboard');

    Route::get('/daftar-poli', [PoliController::class, 'index'])->name('daftar-poli.index');
    Route::post('/daftar-poli', [PoliController::class, 'store'])->name('daftar-poli.store');
    Route::delete('/daftar-poli/{daftarPoli}', [PoliController::class, 'destroy'])->name('daftar-poli.destroy');
});
