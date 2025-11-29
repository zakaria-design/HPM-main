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
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $userId = $user->user_id;

        // Hitung jumlah semua surat
        $jumlahSph = DB::table('sph')->where('user_id', $userId)->count();
        $jumlahInv = DB::table('inv')->where('user_id', $userId)->count();
        $jumlahSkt = DB::table('skt')->where('user_id', $userId)->count();

        // ==============================
        // 🔴 SURAT GAGAL (SPH + INV)
        // ==============================
        $sphGagal = DB::table('sph')
            ->where('user_id', $userId)
            ->where('status', 'gagal')
            ->select('id','nama_customer','nomor_surat','nominal','status',DB::raw('"SPH" as jenis'))
            ->get();

        $invGagal = DB::table('inv')
            ->where('user_id', $userId)
            ->where('status', 'gagal')
            ->select('id','nama_customer','nomor_surat','nominal','status',DB::raw('"INV" as jenis'))
            ->get();

        // Gabungkan SPH & INV → surat gagal
        $suratGagal = $sphGagal->merge($invGagal);

        // Hitung total gagal
        $jumlahSuratGagal = $suratGagal->count();

        // ==============================
        // 🟡 SURAT PROGRES (status NULL)
        // ==============================
        $sphProgres = DB::table('sph')
            ->where('user_id', $userId)
            ->whereNull('status')
            ->select('id','nama_customer','nomor_surat','nominal','status',DB::raw('"SPH" as jenis'))
            ->get();

        $invProgres = DB::table('inv')
            ->where('user_id', $userId)
            ->whereNull('status')
            ->select('id','nama_customer','nomor_surat','nominal','status',DB::raw('"INV" as jenis'))
            ->get();

        // Gabungkan SPH & INV → surat progres
        $suratProgres = $sphProgres->merge($invProgres);

        // Hitung total progres
        $jumlahSuratProgres = $suratProgres->count();

        // ==============================
        // TOTAL CUSTOMER UNIK
        // ==============================
        $totalCustomerUnik = DB::table('sph')->where('user_id', $userId)->pluck('nama_customer')
            ->merge(DB::table('inv')->where('user_id', $userId)->pluck('nama_customer'))
            ->merge(DB::table('skt')->where('user_id', $userId)->pluck('nama_customer'))
            ->unique()
            ->count();

        // ==============================
        // TOTAL SURAT
        // ==============================
        $totalSurat = $jumlahSph + $jumlahInv + $jumlahSkt;

        return view('manager.dashboard.index', compact(
            'jumlahSph',
            'jumlahInv',
            'jumlahSkt',
            'jumlahSuratGagal',
            'jumlahSuratProgres',
            'suratGagal',
            'suratProgres',
            'totalSurat',
            'totalCustomerUnik'
        ));
    }
}
