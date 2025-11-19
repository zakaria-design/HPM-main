<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class DaftarSuratController extends Controller
{
    public function index(Request $request)
{
    $userId = Auth::user()->user_id;

    // Ambil semua SPH untuk user ini
    $sph = DB::table('sph')
        ->where('user_id', $userId)
        ->select('nama_customer', 'nomor_surat', 'nominal', 'created_at', DB::raw('"SPH" as jenis'))
        ->get();

    // Ambil semua INV untuk user ini
    $inv = DB::table('inv')
        ->where('user_id', $userId)
        ->select('nama_customer', 'nomor_surat', 'nominal', 'created_at', DB::raw('"INV" as jenis'))
        ->get();

    // Ambil semua SKT untuk user ini
    $skt = DB::table('skt')
        ->where('user_id', $userId)
        ->select('nama_customer', 'nomor_surat', DB::raw('NULL as nominal'), 'created_at', DB::raw('"SKT" as jenis'))
        ->get();

    // Gabungkan
    $all = $sph->merge($inv)->merge($skt)
        ->sortByDesc('created_at')
        ->values();

    // ============================
    // 🔍 FILTER JENIS SURAT
    // ============================
    $jenis = $request->jenis;

    if ($jenis && $jenis !== 'semua') {
        $all = $all->filter(function ($item) use ($jenis) {
            return strtolower($item->jenis) === strtolower($jenis);
        })->values();
    }

    $kategori = $request->kategori;

    // ============================
    // 🔍 FILTER JENIS CUSTOMER
    // ============================
    if ($kategori && $kategori !== 'semua') {

        $all = $all->filter(function ($item) use ($kategori) {
            $nama = strtolower(trim($item->nama_customer));

            // daftar prefix perusahaan
            $prefixPerusahaan = ['pt', 'cv', 'ud', 'pd', 'pt.', 'cv.', 'ud.', 'pd.'];

            // cek perusahaan
            $isPerusahaan = false;
            foreach ($prefixPerusahaan as $p) {
                if (str_starts_with($nama, $p . ' ')) {
                    $isPerusahaan = true;
                    break;
                }
            }

            // daftar prefix perorangan
            $prefixPerorangan = ['ibu', 'bpk', 'bapak', 'pak'];

            $isPerorangan = false;
            foreach ($prefixPerorangan as $p) {
                if (str_starts_with($nama, $p . ' ')) {
                    $isPerorangan = true;
                    break;
                }
            }

            // logika filter
            if ($kategori === 'perusahaan') {
                return $isPerusahaan;
            }

            if ($kategori === 'perorangan') {
                return $isPerorangan || (!$isPerusahaan); 
                // nama tanpa prefix perusahaan dianggap perorangan
            }

            return true;
        })->values();
    }

    // ============================
    // 🔍 FILTER PENCARIAN
    // ============================
    $search = $request->search;

    if ($search) {
        $all = $all->filter(function ($item) use ($search) {
            return stripos($item->nama_customer, $search) !== false;
        })->values();
    }



    // Pagination manual
    $perPage = 10;
    $currentPage = request('page', 1);

    $currentItems = $all->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $paginated = new LengthAwarePaginator(
        $currentItems,
        $all->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url()]
    );

    return view('manager.daftarsurat.index', [
        'surat' => $paginated,
        'jenis' => $jenis ?? 'semua'
    ]);
}

}
