<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\DaftarSuratExport;
use App\Exports\SuratGagalExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class SphGagalController extends Controller
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
            'sph.marketing',
            'sph.created_at',
            'sph.updated_at',
            'users.name as user_name',
            DB::raw('"SPH" as jenis')
        )
        ->where('sph.status', 'gagal')
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
            'inv.marketing',
            'inv.created_at',
            'inv.updated_at',
            'users.name as user_name',
            DB::raw('"INV" as jenis')
        )
        ->where('inv.status', 'gagal')
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

    return view('admin.sphgagal.index', [
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
                'sph.marketing',
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
                'inv.marketing',
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

    public function destroy(Request $request, $id)
    {
        // jenis = SPH atau INV
        $jenis = $request->jenis;

        if (!$jenis) {
            return redirect()->back()->with('error', 'Jenis surat tidak ditemukan!');
        }

        // Tentukan tabel berdasarkan jenis
        if ($jenis == "SPH") {
            DB::table('sph')->where('id', $id)->delete();
        } else {
            DB::table('inv')->where('id', $id)->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }


        // eksport data
 public function exportExcel(Request $request)
{
    $users = DB::table('users')
        ->select('user_id', 'name')
        ->get()
        ->keyBy('user_id');

    $sph = DB::table('sph')
        ->join('users', 'sph.user_id', '=', 'users.user_id')
        ->select(
            'sph.user_id',
            'users.name as user_name',
            'sph.nama_customer',
            'sph.nomor_surat',
            'sph.nominal',
            'sph.marketing',
            'sph.status',
            'sph.updated_at',
            'sph.created_at',
            DB::raw('"SPH" as jenis')
        )
        ->where('sph.status', 'gagal')
        ->get();

    $inv = DB::table('inv')
        ->join('users', 'inv.user_id', '=', 'users.user_id')
        ->select(
            'inv.user_id',
            'users.name as user_name',
            'inv.nama_customer',
            'inv.nomor_surat',
            'inv.nominal',
            'inv.marketing',
            'inv.status',
            'inv.updated_at',
            'inv.created_at',
            DB::raw('"INV" as jenis')
        )
        ->where('inv.status', 'gagal')
        ->get();


    $all = $sph->merge($inv)->sortByDesc('created_at')->values();

    // 🔍 Filter JENIS
    if ($request->jenis && $request->jenis !== 'semua') {
        $all = $all->filter(fn($i) => strtolower($i->jenis) === strtolower($request->jenis))->values();
    }

    // 🔍 Filter BULAN
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    if ($bulan) {
        $all = $all->filter(function ($item) use ($bulan) {
            return \Carbon\Carbon::parse($item->created_at)->month == $bulan;
        })->values();
    }

    // 🔍 Filter TAHUN
    if ($tahun) {
        $all = $all->filter(function ($item) use ($tahun) {
            return \Carbon\Carbon::parse($item->created_at)->year == $tahun;
        })->values();
    }

    return Excel::download(new SuratGagalExport($all), 'surat-gagal.xlsx');
}



}