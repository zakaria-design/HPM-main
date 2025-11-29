<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class SphSuccessController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $jenis_surat = $request->get('jenis', 'semua'); // SPH / INV / semua

    // ======================
    // Ambil SPH (status = berhasil)
    // ======================
    $sph = DB::table('sph')
        ->leftJoin('users', 'sph.user_id', '=', 'users.user_id')
        ->select(
            'sph.id',
            'sph.nama_customer',
            'sph.nomor_surat',
            'sph.nominal',
            'sph.status',
            'sph.created_at',
            'sph.updated_at',
            'users.name as user_name',
            DB::raw('"SPH" as jenis')
        )
        ->where('sph.status', 'berhasil')
        ->when($search, fn($q) =>
            $q->where('sph.nama_customer', 'LIKE', "%{$search}%")
        )
        ->get();

    // ======================
    // Ambil INV (status = berhasil)
    // ======================
    $inv = DB::table('inv')
        ->leftJoin('users', 'inv.user_id', '=', 'users.user_id')
        ->select(
            'inv.id',
            'inv.nama_customer',
            'inv.nomor_surat',
            'inv.nominal',
            'inv.status',
            'inv.created_at',
            'inv.updated_at',
            'users.name as user_name',
            DB::raw('"INV" as jenis')
        )
        ->where('inv.status', 'berhasil')
        ->when($search, fn($q) =>
            $q->where('inv.nama_customer', 'LIKE', "%{$search}%")
        )
        ->get();

    // ======================
    // Gabungkan SPH + INV
    // ======================
    $merged = collect($sph)->merge($inv);

    // ======================
    // FILTER DROPDOWN JENIS SURAT
    // ======================
    if ($jenis_surat !== 'semua') {
        $merged = $merged->where('jenis', $jenis_surat)->values();
    }

    // Sortir terbaru
    $merged = $merged->sortByDesc('created_at')->values();


    // ======================
    // Pagination Manual
    // ======================
    $perPage = 20;
    $page = $request->input('page', 1);

    $paginated = new LengthAwarePaginator(
        $merged->slice(($page - 1) * $perPage, $perPage)->values(),
        $merged->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('admin.sphsuccess.index', [
        'data' => $paginated,
        'search' => $search,
        'jenis_surat' => $jenis_surat, // KIRIM KE VIEW
    ]);
}



    // ======================
    // DETAIL (SPH saja)
    // ======================
    public function detail($id)
    {
        // =========================
        // CARI DI SPH
        // =========================
        $sph = DB::table('sph')
            ->leftJoin('users', 'sph.user_id', '=', 'users.user_id')
            ->select(
                'sph.id',
                'sph.nama_customer',
                'sph.nomor_surat',
                'sph.nominal',
                'sph.status',
                'sph.created_at',
                'sph.updated_at',
                'users.name as user_name',
                DB::raw('"SPH" as jenis')
            )
            ->where('sph.id', $id)
            ->first();

        if ($sph) {
            return response()->json($sph);
        }


        // =========================
        // CARI DI INV
        // =========================
        $inv = DB::table('inv')
            ->leftJoin('users', 'inv.user_id', '=', 'users.user_id')
            ->select(
                'inv.id',
                'inv.nama_customer',
                'inv.nomor_surat',
                'inv.nominal',
                'inv.status',
                'inv.created_at',
                'inv.updated_at',
                'users.name as user_name',
                DB::raw('"INV" as jenis')
            )
            ->where('inv.id', $id)
            ->first();

        if ($inv) {
            return response()->json($inv);
        }

        // =========================
        // DATA TIDAK DITEMUKAN
        // =========================
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    // edit data 
  public function update(Request $request, $id)
{
    // Validasi
    $request->validate([
        'nama_customer' => 'required|string|max:255',
        'nominal' => 'required|numeric',
        'status' => 'nullable|string', // ubah: boleh null
        'jenis' => 'required|string', // SPH / INV
    ]);

    // Jika value status kosong => jadikan null
    $status = $request->status === "" ? null : $request->status;

    // Data yang mau diupdate
    $dataUpdate = [
        'nama_customer' => $request->nama_customer,
        'nominal' => $request->nominal,
        'status' => $status,
        'updated_at' => now(),
    ];

    // Tentukan tabel
    if ($request->jenis == "SPH") {
        DB::table('sph')->where('id', $id)->update($dataUpdate);
    } else {
        DB::table('inv')->where('id', $id)->update($dataUpdate);
    }

    return redirect()->back()->with('success', 'Data berhasil diperbarui!');
}



}