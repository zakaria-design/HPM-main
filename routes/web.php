<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DaftarSuratController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\PengajuanController;
use App\Http\Controllers\Manager\UpdateSuratController;

Route::get('/', function () {
    return view('auth.landing');
});


// rute superadmin
// Route::view('superadmin/user/index','superadmin.user.index')->name('superadmin.user.index');


// contoh memanggil middle =ware alias
// Route::resource('users', UserController::class)->middleware('isSuperAdmin');


// Login routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// karyawan routes
Route::middleware(['auth', 'isKaryawan'])->group(function () {
    Route::view('karyawan/dashboard/index', 'karyawan.dashboard.index')->name('karyawan.dashboard.index');
    Route::view('karyawan/pengajuan/index', 'karyawan.pengajuan.index')->name('karyawan.pengajuan.index');
    Route::view('karyawan/daftarsurat/index','karyawan.daftarsurat.index')->name('karyawan.daftarsurat.index');
    Route::view('karyawan/updatesurat/index','karyawan.updatesurat.index')->name('karyawan.updatesurat.index');
    Route::view('karyawan/presensi/index','karyawan.presensi.index')->name('karyawan.presensi.index');
});

// Manager routes
Route::middleware(['auth', 'isManager'])->group(function () {
    // Dashboard
    Route::get('manager/dashboard/index', [DashboardController::class, 'index'])->name('manager.dashboard.index');
    // Pengajuan Surat
    Route::prefix('manager/pengajuan/index')->name('manager.pengajuan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Manager\PengajuanController::class, 'index'])->name('index');
        Route::post('/store', [\App\Http\Controllers\Manager\PengajuanController::class, 'store'])->name('store');
    });
    // Daftar Surat
    Route::get('manager/daftarsurat', [\App\Http\Controllers\Manager\DaftarSuratController::class, 'index'])->name('manager.daftarsurat.index');
    // update surat
    Route::get('manager/update-surat', [App\Http\Controllers\Manager\UpdateSuratController::class, 'index'])->name('manager.updatesurat.index');
    Route::get('manager/update-surat/gagal/{id}', [App\Http\Controllers\Manager\UpdateSuratController::class, 'gagal'])->name('manager.surat.gagal');
    Route::get('manager/update-surat/berhasil/{id}', [App\Http\Controllers\Manager\UpdateSuratController::class, 'berhasil'])->name('manager.surat.berhasil');
    Route::get('/manager/update-surat/detail/{id}/{type}', [UpdateSuratController::class, 'detail'])->name('manager.updatesurat.detail');

});

    // // Route untuk menampilkan halaman (GET request)
    // Route::get('/manager/pengajuan/index', [PengajuanController::class, 'index'])->name('manager.pengajuan.index');

    // // Route untuk menyimpan pengajuan (POST request)
    // Route::post('/manager/pengajuan/index', [PengajuanController::class, 'store'])->name('manager.pengajuan.store');


    // // Route::view('manager/pengajuan/index', 'manager.pengajuan.index')->name('manager.pengajuan.index');
    // Route::view('manager/daftarsurat/index','manager.daftarsurat.index')->name('manager.daftarsurat.index');
    // Route::view('manager/updatesurat/index','manager.updatesurat.index')->name('manager.updatesurat.index');
    // Route::view('manager/presensi/index','manager.presensi.index')->name('manager.presensi.index');
    // Route::get('/daftar-surat/export-pdf', [App\Http\Controllers\DaftarsuratController::class, 'exportPdf'])->name('daftarsurat.exportPdf');


// profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.updatePassword');
});




// Admin routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::view('/admin/dashboard/index', 'admin.dashboard.index')->name('admin.dashboard.index');
    Route::view('/admin/inputuser/index', 'admin.inputuser.index')->name('admin.inputuser.index');
    Route::view('/admin/daftarsurat/index', 'admin.daftarsurat.index')->name('admin.daftarsurat.index');
    Route::view('/admin/presensi/index', 'admin.presensi.index')->name('admin.presensi.index');
    Route::view('/admin/sphprogres/index', 'admin.sphprogres.index')->name('admin.sphprogres.index');
     Route::view('admin/updatesurat/index','admin.updatesurat.index')->name('admin.updatesurat.index');
    Route::view('/admin/sphgagal/index', 'admin.sphgagal.index')->name('admin.sphgagal.index');
    Route::view('/admin/sphsuccess/index', 'admin.sphsuccess.index')->name('admin.sphsuccess.index');
});

// Pimpinan routes
Route::middleware(['auth', 'isDirektur'])->group(function () {
    Route::view('/pimpinan/dashboard/index', 'pimpinan.dashboard.index')->name('pimpinan.dashboard.index');
    Route::view('/pimpinan/clients/index', 'pimpinan.clients.index')->name('pimpinan.clients.index');
    Route::view('/pimpinan/daftarsurat/index', 'pimpinan.daftarsurat.index')->name('pimpinan.daftarsurat.index');
    Route::view('/pimpinan/presensi/index', 'pimpinan.presensi.index')->name('pimpinan.presensi.index');
    Route::view('/pimpinan/sphprogres/index', 'pimpinan.sphprogres.index')->name('pimpinan.sphprogres.index');
    Route::view('/pimpinan/sphgagal/index', 'pimpinan.sphgagal.index')->name('pimpinan.sphgagal.index');
    Route::view('/pimpinan/sphsuccess/index', 'pimpinan.sphsuccess.index')->name('pimpinan.sphsuccess.index');
});
