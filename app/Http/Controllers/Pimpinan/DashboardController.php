<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===============================
        // Hitung jumlah client unik & total surat
        // ===============================
        $sph = DB::table('sph')->select('nama_customer','nomor_surat','created_at');
        $inv = DB::table('inv')->select('nama_customer','nomor_surat','created_at');
        $skt = DB::table('skt')->select('nama_customer','nomor_surat','created_at');

        $allData = $sph->unionAll($inv)->unionAll($skt)->get();

        $uniqueClientCount = $allData->pluck('nama_customer')->unique()->count();
        $totalSurat = $allData->count();

        // ===============================
        // Hitung jumlah surat per bulan
        // ===============================
        $getMonthlyData = function($table){
            return DB::table($table)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total','month')
                ->toArray();
        };

        $invMonthly = $getMonthlyData('inv');
        $sktMonthly = $getMonthlyData('skt');
        $sphMonthly = $getMonthlyData('sph');

        // ubah ke integer agar tidak muncul ".0"
        $invMonthly = array_map('intval', $invMonthly);
        $sktMonthly = array_map('intval', $sktMonthly);
        $sphMonthly = array_map('intval', $sphMonthly);

        // format 12 bulan
        $formatMonthly = function($data){
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[] = $data[$i] ?? 0;
            }
            return $result;
        };

        $invMonthly = $formatMonthly($invMonthly);
        $sphMonthly = $formatMonthly($sphMonthly);
        $sktMonthly = $formatMonthly($sktMonthly);

      // ===============================
        // Hitung jumlah surat sph & inv gagal
        // ===============================
        $sphGagal = DB::table('sph')->where('status', 'gagal')->count();
        $invGagal = DB::table('inv')->where('status', 'gagal')->count();

        // Total gagal (sph + inv)
        $gagal = $sphGagal + $invGagal;

       

        // ===============================
        // Hitung jumlah user berdasarkan role
        // ===============================
        // $karyawan = DB::table('users')->where('role', 'karyawan')->pluck('id');
        $manager  = DB::table('users')->where('role', 'manager')->pluck('id');
        $admin    = DB::table('users')->where('role', 'admin')->pluck('id');

        $allUsers = ($manager)->merge($admin)->unique();
        $totalUserCount = $allUsers->count();

        return view('pimpinan.dashboard.index', [
            'uniqueClientCount' => $uniqueClientCount,
            'totalUserCount'    => $totalUserCount,
            'totalSurat'        => $totalSurat,
            'gagal'             => $gagal,
            'invMonthly'        => $invMonthly,
            'sphMonthly'        => $sphMonthly,
            'sktMonthly'        => $sktMonthly,
        ]);
    }
}
