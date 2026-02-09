<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Material Routes (Admin & Super Admin)
    Route::middleware(['role:Super Admin|Admin'])->group(function () {
        Route::get('rekap-timbangan/export-excel', [\App\Http\Controllers\RekapTimbanganController::class, 'exportExcel'])->name('rekap-timbangan.export.excel');
        Route::get('rekap-timbangan/export-pdf', [\App\Http\Controllers\RekapTimbanganController::class, 'exportPdf'])->name('rekap-timbangan.export.pdf');
        Route::resource('rekap-timbangan', \App\Http\Controllers\RekapTimbanganController::class);
        Route::resource('raw-material', \App\Http\Controllers\RawMaterialController::class);
        Route::resource('keluar-material', \App\Http\Controllers\KeluarMaterialController::class);
        Route::resource('rekap-lebur', \App\Http\Controllers\RekapLeburController::class);
    });

    // Finance Routes (Kasir & Super Admin)
    Route::middleware(['role:Super Admin|Kasir'])->group(function () {
        Route::get('penjualan/export-pdf', [\App\Http\Controllers\ExportController::class, 'penjualanPdf'])->name('penjualan.export.pdf');
        Route::get('penjualan/export-excel', [\App\Http\Controllers\ExportController::class, 'penjualanExcel'])->name('penjualan.export.excel');
        Route::resource('penjualan', \App\Http\Controllers\PenjualanController::class);

        Route::get('laporan-kas/export-pdf', [\App\Http\Controllers\ExportController::class, 'kasPdf'])->name('laporan-kas.export.pdf');
        Route::resource('laporan-kas', \App\Http\Controllers\LaporanKasController::class);

        // Pengajuan Kas Specific Routes
        Route::post('pengajuan-kas/{pengajuan_kas}/approve', [\App\Http\Controllers\PengajuanKasController::class, 'approve'])->name('pengajuan-kas.approve');
        Route::post('pengajuan-kas/{pengajuan_kas}/reject', [\App\Http\Controllers\PengajuanKasController::class, 'reject'])->name('pengajuan-kas.reject');
        Route::resource('pengajuan-kas', \App\Http\Controllers\PengajuanKasController::class);

        Route::resource('hutang', \App\Http\Controllers\HutangController::class);
        Route::resource('piutang', \App\Http\Controllers\PiutangController::class);
    });

    // Admin Routes (Super Admin Only)
    Route::middleware(['role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('activity-logs', \App\Http\Controllers\Admin\ActivityLogController::class)->only(['index', 'show']);
    });
});

require __DIR__ . '/auth.php';
