<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DaftarSuratController;
use App\Http\Controllers\Admin\SphGagalController;
use App\Http\Controllers\Admin\InputUserController;
use App\Http\Controllers\Admin\SphSuccessController;
use App\Http\Controllers\Pimpinan\ClientsController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\PengajuanController;
use App\Http\Controllers\Manager\UpdateSuratController;

Route::get('/', function () {
    return view('auth.landing');
});



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


// profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profil.updatePassword');
});


// Admin routes
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // dashboard
    Route::get('admin/dashboard/index', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');
    // input user
    Route::get('/admin/input-user', [InputUserController::class, 'index'])->name('admin.inputuser.index');
    Route::post('/admin/input-user/store', [InputUserController::class, 'store'])->name('admin.inputuser.store');
    Route::delete('/admin/input-user/delete/{id}', [InputUserController::class, 'destroy'])->name('admin.user.delete');
    // Daftar Surat
    Route::get('admin/daftarsurat', [\App\Http\Controllers\Admin\DaftarSuratController::class, 'index'])->name('admin.daftarsurat.index');
    // update surat
    Route::get('admin/sph-progres', [App\Http\Controllers\Admin\UpdateSuratController::class, 'index'])->name('admin.sphprogres.index');
    Route::get('admin/sph-progres/gagal/{id}', [App\Http\Controllers\Admin\UpdateSuratController::class, 'gagal'])->name('admin.surat.gagal');
    Route::get('admin/sph-progres/berhasil/{id}', [App\Http\Controllers\Admin\UpdateSuratController::class, 'berhasil'])->name('admin.surat.berhasil');
    // sph success
    Route::get('admin/sphsuccess', [SphSuccessController::class, 'index'])->name('admin.sphsuccess.index');
    Route::get('admin/sphsuccess/detail/{id}', [SphSuccessController::class, 'detail'])->name('admin.sphsuccess.detail');
    // sph gagal
    Route::get('admin/sphgagal', [SphGagalController::class, 'index'])->name('admin.sphgagal.index');
    Route::get('admin/sphgagal/detail/{id}', [SphGagalController::class, 'detail'])->name('admin.sphgagal.detail');

});

// Pimpinan routes
Route::middleware(['auth', 'isDirektur'])->group(function () {
    // dashboard
    Route::get('pimpinan/dashboard/index', [\App\Http\Controllers\Pimpinan\DashboardController::class, 'index'])->name('pimpinan.dashboard.index');

    // Route::view('/pimpinan/dashboard/index', 'pimpinan.dashboard.index')->name('pimpinan.dashboard.index');
    //clients
    Route::get('pimpinan/clients', [ClientsController::class, 'index'])->name('pimpinan.clients.index');
    // Daftar Surat
    Route::get('pimpinan/daftarsurat', [\App\Http\Controllers\Pimpinan\DaftarSuratController::class, 'index'])->name('pimpinan.daftarsurat.index');
    // sph progres
    Route::get('pimpinan/sph-progres', [App\Http\Controllers\Pimpinan\SphProgresController::class, 'index'])->name('pimpinan.sphprogres.index');
    Route::get('pimpinan/sph-progres/gagal/{id}', [App\Http\Controllers\Pimpinan\SphProgresController::class, 'gagal'])->name('admin.surat.gagal');
    Route::get('pimpinan/sph-progres/berhasil/{id}', [App\Http\Controllers\Pimpinan\SphProgresController::class, 'berhasil'])->name('admin.surat.berhasil');
    // sph success
    Route::get('pimpinan/sphsuccess', [App\Http\Controllers\Pimpinan\SphSuccessController::class, 'index'])->name('pimpinan.sphsuccess.index');
    Route::get('pimpinan/sphsuccess/detail/{id}', [App\Http\Controllers\Pimpinan\SphSuccessController::class, 'detail'])->name('pimpinan.sphsuccess.detail');
    // sph gagal
    Route::get('pimpinan/sphgagal', [App\Http\Controllers\Pimpinan\SphGagalController::class, 'index'])->name('pimpinan.sphgagal.index');
    Route::get('pimpinan/sphgagal/detail/{id}', [App\Http\Controllers\Pimpinan\SphGagalController::class, 'detail'])->name('pimpinan.sphgagal.detail');

});
