<?php 

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah surat per tabel tanpa filter user
        $jumlahProgresSph = DB::table('progres_sph')->count();
        $jumlahSphGagal   = DB::table('sph_gagal')->count();
        $jumlahSph        = DB::table('sph')->count();
        $jumlahInv        = DB::table('inv')->count();
        $jumlahSkt        = DB::table('skt')->count();

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

        // Ambil data hari ini dari progres_sph
        $todayProgresSph = DB::table('progres_sph')
            ->leftJoin('users', 'progres_sph.user_id', '=', 'users.user_id')
            ->whereDate('progres_sph.created_at', now())
            ->select('progres_sph.*', 'users.name as user_name')
            ->get()
            ->map(function($item) {
                $item->jenis = 'Progres SPH';
                return $item;
            });

        // Ambil data hari ini dari inv
        $todayInv = DB::table('inv')
            ->leftJoin('users', 'inv.user_id', '=', 'users.user_id')
            ->whereDate('inv.created_at', now())
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
            'jumlahProgresSph',
            'jumlahSphGagal',
            'jumlahSph',
            'jumlahInv',
            'jumlahSkt',
            'todayAll'
        ));
    }
}
