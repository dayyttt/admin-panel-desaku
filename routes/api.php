<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes — /api/v1/
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Profil Desa
    Route::get('/desa', [Api\DesaConfigController::class, 'index']);

    // Statistik Penduduk
    Route::get('/statistik', [Api\StatistikController::class, 'index']);
    Route::get('/statistik/agama', [Api\StatistikController::class, 'agama']);
    Route::get('/statistik/pekerjaan', [Api\StatistikController::class, 'pekerjaan']);
    Route::get('/statistik/pendidikan', [Api\StatistikController::class, 'pendidikan']);
    Route::get('/statistik/umur', [Api\StatistikController::class, 'umur']);
    Route::get('/statistik/piramida', [Api\StatistikController::class, 'piramida']);
    Route::get('/statistik/kelompok-rentan', [Api\StatistikController::class, 'kelompokRentan']);

    // Wilayah
    Route::get('/wilayah', [Api\WilayahController::class, 'index']);

    // Perangkat Desa
    Route::get('/perangkat-desa', [Api\PerangkatDesaController::class, 'index']);

    // Surat
    Route::get('/surat/jenis', [Api\SuratController::class, 'jenis']);
    Route::get('/surat/verifikasi/{kode}', [Api\SuratController::class, 'verifikasi']);

    // Keuangan
    Route::get('/keuangan/ringkasan', [Api\KeuanganController::class, 'ringkasan']);

    // Laporan
    Route::get('/laporan/kependudukan-bulanan', [Api\LaporanController::class, 'kependudukanBulanan']);
    Route::get('/laporan/kelompok-rentan', [Api\LaporanController::class, 'kelompokRentan']);

    // Web Publik
    Route::get('/web/slider', [Api\WebPublikController::class, 'slider']);
    Route::get('/web/teks-berjalan', [Api\WebPublikController::class, 'teksBerjalan']);
    Route::get('/web/artikel', [Api\WebPublikController::class, 'artikel']);
    Route::get('/web/artikel/{slug}', [Api\WebPublikController::class, 'artikelDetail']);
    Route::get('/web/galeri', [Api\WebPublikController::class, 'galeri']);
    Route::get('/web/potensi', [Api\WebPublikController::class, 'potensi']);
    Route::get('/web/lapak', [Api\WebPublikController::class, 'lapak']);
    Route::get('/web/lapak/{slug}', [Api\WebPublikController::class, 'lapakDetail']);
    Route::get('/web/halaman/{slug}', [Api\WebPublikController::class, 'halaman']);
    Route::get('/web/halaman-menu', [Api\WebPublikController::class, 'halamanMenu']);
    Route::get('/web/desa-config', [Api\WebPublikController::class, 'desaConfig']);

    // Desa Info (Profil, Pemerintahan, Layanan, Kontak)
    Route::get('/desa-info', [Api\DesaInfoController::class, 'index']);
    Route::get('/desa-info/{key}', [Api\DesaInfoController::class, 'show']);
    
    // Web Kontak (Submit form)
    Route::post('/web/kontak', [Api\WebKontakController::class, 'store']);
});
