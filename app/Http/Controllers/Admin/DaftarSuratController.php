<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class DaftarSuratController extends Controller
{
    public function index(Request $request)
    {
        // ============================
        // 🔹 Ambil semua user (untuk mapping user_id → name)
        // ============================
        $users = DB::table('users')
            ->select('user_id', 'name')
            ->get()
            ->keyBy('user_id');

        // ============================
        // 🔹 Ambil semua SPH dari semua user
        // ============================
        $sph = DB::table('sph')
    ->join('users', 'sph.user_id', '=', 'users.user_id')
    ->select(
        'sph.user_id',
        'users.name as user_name',
        'sph.nama_customer',
        'sph.nomor_surat',
        'sph.nominal',
        'sph.updated_at',
        'sph.created_at',
        DB::raw('"SPH" as jenis')
    )
    ->get();


        // ============================
        // 🔹 Ambil semua INV dari semua user
        // ============================
$inv = DB::table('inv')
    ->join('users', 'inv.user_id', '=', 'users.user_id')
    ->select(
        'inv.user_id',
        'users.name as user_name',
        'inv.nama_customer',
        'inv.nomor_surat',
        'inv.nominal',
        'inv.created_at',
        DB::raw('"INV" as jenis')
    )
    ->get();


        // ============================
        // 🔹 Ambil semua SKT dari semua user
        // ============================
$skt = DB::table('skt')
    ->join('users', 'skt.user_id', '=', 'users.user_id')
    ->select(
        'skt.user_id',
        'users.name as user_name',
        'skt.nama_customer',
        'skt.nomor_surat',
        DB::raw('NULL as nominal'),
        'skt.created_at',
        DB::raw('"SKT" as jenis')
    )
    ->get();


        // ============================
        // 🔹 Gabungkan semua surat
        // ============================
        $all = $sph->merge($inv)->merge($skt)
            ->sortByDesc('created_at')
            ->values();

        // ============================
        // 🔍 FILTER JENIS SURAT
        // ============================
        $jenis = $request->jenis;

        if ($jenis && $jenis !== 'semua') {
            $all = $all->filter(fn($i) => strtolower($i->jenis) == strtolower($jenis))->values();
        }

        // ============================
        // 🔍 FILTER JENIS CUSTOMER
        // ============================
        $kategori = $request->kategori;

        if ($kategori && $kategori !== 'semua') {

            $all = $all->filter(function ($item) use ($kategori) {
                $nama = strtolower(trim($item->nama_customer));

                $prefixPerusahaan = ['pt', 'cv', 'ud', 'pd', 'pt.', 'cv.', 'ud.', 'pd.'];
                $isPerusahaan = false;
                foreach ($prefixPerusahaan as $p) {
                    if (str_starts_with($nama, $p . ' ')) {
                        $isPerusahaan = true;
                        break;
                    }
                }

                $prefixPerorangan = ['ibu', 'bpk', 'bapak', 'pak'];
                $isPerorangan = false;
                foreach ($prefixPerorangan as $p) {
                    if (str_starts_with($nama, $p . ' ')) {
                        $isPerorangan = true;
                        break;
                    }
                }

                if ($kategori === 'perusahaan') return $isPerusahaan;
                if ($kategori === 'perorangan') return $isPerorangan || (!$isPerusahaan);

                return true;
            })->values();
        }

        // ============================
        // 🔍 FILTER PENCARIAN
        // ============================
        if ($request->search) {
            $all = $all->filter(fn($i) => stripos($i->nama_customer, $request->search) !== false)->values();
        }

        // ============================
        // 🔸 Pagination Manual
        // ============================
        $perPage = 20;
        $page = request('page', 1);

        $slice = $all->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $slice,
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('admin.daftarsurat.index', [
            'surat' => $paginated,
            'jenis' => $jenis ?? 'semua'
        ]);
    }
}
