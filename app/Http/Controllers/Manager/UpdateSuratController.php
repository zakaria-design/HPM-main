<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class UpdateSuratController extends Controller
{

    public function index(Request $request)
{
    $userId = Auth::user()->user_id;
    $perPage = 10;
    $jenis = $request->jenis ?? 'semua';
    $kategori = $request->kategori ?? 'semua';
    $search = $request->search ?? null;


    // ================================
    // Ambil data SPH
    // ================================
    $sph = DB::table('sph')
        ->where('user_id', $userId)
        ->whereNull('status')
        ->select(
            'id',
            'nama_customer',
            'nomor_surat',
            'nominal',
            'marketing',
            'created_at',
            DB::raw("'sph' as sumber_tabel"),
            DB::raw("'SPH' as jenis_surat")
        )
        ->get();

    // ================================
    // Ambil data INV
    // ================================
    $inv = DB::table('inv')
        ->where('user_id', $userId)
        ->whereNull('status')
        ->select(
            'id',
            'nama_customer',
            'nomor_surat',
            'nominal',
            'marketing',
            'created_at',
            DB::raw("'inv' as sumber_tabel"),
            DB::raw("'INV' as jenis_surat")
        )
        ->get();

    // ================================
    // Gabungkan semua
    // ================================
    $merged = collect($sph)->merge($inv);

    // ================================
    // Tambah FILTER jenis_surat
    // ================================
    $jenis = $request->jenis;

    if ($jenis && $jenis !== 'semua') {
        $merged = $merged->filter(function ($item) use ($jenis) {
            return strtolower($item->jenis_surat) === strtolower($jenis);
        })->values();
    }
        


    // ================================
    // Tambah SEARCH nama_customer
    // ================================
    if ($request->filled('search')) {
        $merged = $merged->filter(function ($item) use ($request) {
            return stripos($item->nama_customer, $request->search) !== false;
        });
    }

    // Sort hasil akhir
    $merged = $merged->sortByDesc('created_at')->values();

    // ================================
    // Pagination Manual
    // ================================
    $page = $request->input('page', 1);
    $itemsPaginated = new LengthAwarePaginator(
        $merged->slice(($page - 1) * $perPage, $perPage)->values(),
        $merged->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('manager.updatesurat.index', [
        'surat' => $itemsPaginated,
        'jenis_surat' => $request->jenis,
        'search' => $request->search
    ]);
}



        public function updateStatus($table, $id, $status)
    {
        if (!in_array($table, ['sph', 'inv'])) {
            abort(404);
        }

        DB::table($table)
            ->where('id', $id)
            ->update([
                'status' => $status,
                'updated_at' => now(),
            ]);

        // Pesan berbeda tergantung tombol yang diklik
        $message = $status === 'gagal'
            ? ' Surat ditandai sebagai surat GAGAL.'
            : ' Surat ditandai sebagai surat BERHASIL.';

        return back()->with('success', $message);
    }

}
