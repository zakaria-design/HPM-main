<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // ==============================
        // AMBIL DATA SURAT GAGAL
        // ==============================

        // SPH Gagal
        $sphGagal = DB::table('sph')
            ->where('status', 'gagal')
            ->select('id', 'nama_customer', 'nomor_surat', 'nominal', 'status', DB::raw('"SPH" as jenis'))
            ->get();

        // INV Gagal
        $invGagal = DB::table('inv')
            ->where('status', 'gagal')
            ->select('id', 'nama_customer', 'nomor_surat', 'nominal', 'status', DB::raw('"INV" as jenis'))
            ->get();

        // Gabungkan SPH + INV
        $suratGagal = $sphGagal->merge($invGagal);

        // Hitung jumlah gagal
        $jumlahSphGagal = $sphGagal->count();
        $jumlahInvGagal = $invGagal->count();

        // Total surat gagal
        $jumlahSuratGagal = $jumlahSphGagal + $jumlahInvGagal;



        // ==============================
        // JUMLAH SURAT PER TABEL (GET ALL)
        // ==============================
        $jumlahSph = DB::table('sph')->count();
        $jumlahInv = DB::table('inv')->count();
        $jumlahSkt = DB::table('skt')->count();


        // Ambil daftar customer dari masing-masing tabel
        $custSph = DB::table('sph')->pluck('nama_customer');
        $custInv = DB::table('inv')->pluck('nama_customer');
        $custSkt = DB::table('skt')->pluck('nama_customer');

        // Gabungkan lalu ambil unique
        $totalCustomerUnik = $custSph
            ->merge($custInv)
            ->merge($custSkt)
            ->unique()
            ->count();

        // Ambil data hari ini dari progres_sph (status NULL)
        $todayProgresSph = DB::table('sph')
            ->leftJoin('users', 'sph.user_id', '=', 'users.user_id')
            ->whereDate('sph.created_at', now())
            ->whereNull('sph.status')   // ⬅️ Tambahkan filter status NULL
            ->select('sph.*', 'users.name as user_name')
            ->get()
            ->map(function($item) {
                $item->jenis = 'SPH';
                return $item;
            });

        // Ambil data hari ini dari progres_inv (status NULL)
        $todayInv = DB::table('inv')
            ->leftJoin('users', 'inv.user_id', '=', 'users.user_id')
            ->whereDate('inv.created_at', now())
            ->whereNull('inv.status')   // ⬅️ Tambahkan filter status NULL
            ->select('inv.*', 'users.name as user_name')
            ->get()
            ->map(function($item) {
                $item->jenis = 'INV';
                return $item;
            });


        // Ambil data hari ini dari skt
        $todaySkt = DB::table('skt')
            ->leftJoin('users', 'skt.user_id', '=', 'users.user_id')
            ->whereDate('skt.created_at', now())
            ->select('skt.*', 'users.name as user_name')
            ->get()
            ->map(function($item) {
                $item->jenis = 'SKT';
                return $item;
            });

        // Gabungkan semua data
        $todayAll = $todayProgresSph
            ->merge($todayInv)
            ->merge($todaySkt)
            ->sortByDesc('created_at')
            ->values(); // tambahkan values()

        return view('admin.dashboard.index', compact(
            'jumlahSphGagal',
            'jumlahSph',
            'jumlahInv',
            'jumlahSuratGagal',
            'jumlahSkt',
            'todayAll'
        ));
    }
}
