<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    // Pastikan user sudah login
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    $userId = $user->user_id; // varchar id

    // Hitung jumlah surat per tabel
    $jumlahProgresSph = DB::table('progres_sph')->where('user_id', $userId)->count();
    $jumlahSphGagal = DB::table('sph_gagal')->where('user_id', $userId)->count();
    $jumlahSph = DB::table('sph')->where('user_id', $userId)->count();
    $jumlahInv = DB::table('inv')->where('user_id', $userId)->count();
    $jumlahSkt = DB::table('skt')->where('user_id', $userId)->count();

    // Total surat keseluruhan
    $totalSurat = $jumlahSph + $jumlahInv + $jumlahSkt;

    // Ambil daftar customer dari masing-masing tabel
    $custSph = DB::table('sph')->where('user_id', $userId)->pluck('nama_customer');
    $custInv = DB::table('inv')->where('user_id', $userId)->pluck('nama_customer');
    $custSkt = DB::table('skt')->where('user_id', $userId)->pluck('nama_customer');

    // Gabungkan lalu ambil unique
    $totalCustomerUnik = $custSph
        ->merge($custInv)
        ->merge($custSkt)
        ->unique()
        ->count();

    return view('manager.dashboard.index', compact(
        'jumlahProgresSph',
        'jumlahSphGagal',
        'jumlahSph',
        'jumlahInv',
        'jumlahSkt',
        'totalSurat',
        'totalCustomerUnik'
    ));
}

}
