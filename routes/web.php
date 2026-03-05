<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

// Installation routes
Route::middleware('check.not.installed')->prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::get('/requirements', [InstallController::class, 'requirements'])->name('requirements');
    Route::get('/database', [InstallController::class, 'database'])->name('database');
    Route::post('/database/test', [InstallController::class, 'testDatabase'])->name('database.test');
    Route::post('/database', [InstallController::class, 'saveDatabase'])->name('database.save');
    Route::get('/desa', [InstallController::class, 'desa'])->name('desa');
    Route::post('/desa', [InstallController::class, 'saveDesa'])->name('desa.save');
    Route::get('/admin', [InstallController::class, 'admin'])->name('admin');
    Route::post('/admin', [InstallController::class, 'saveAdmin'])->name('admin.save');
    Route::get('/finalize', [InstallController::class, 'finalize'])->name('finalize');
    Route::post('/install', [InstallController::class, 'install'])->name('process');
});

// Main app routes (protected by check.installed)
Route::middleware('check.installed')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// Surat Verification (Public)
Route::get('/verifikasi/{kode}', [\App\Http\Controllers\PublicSuratController::class, 'verify'])->name('surat.verifikasi');
