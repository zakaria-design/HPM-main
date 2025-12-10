<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\DaftarSuratExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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
                'sph.marketing',
                'sph.nomor_surat',
                'sph.nominal',
                'sph.status',
                'sph.updated_at',
                'sph.created_at',
                DB::raw('"SPH" as jenis')
            )
            ->where('sph.status', 'berhasil')   // ⬅️ Tambahkan ini
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
                'inv.marketing',
                'inv.nomor_surat',
                'inv.nominal',
                'inv.status',
                'inv.updated_at',
                'inv.created_at',
                DB::raw('"INV" as jenis')
            )
            ->where('inv.status', 'berhasil')   // ⬅️ Tambahkan ini
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
                'skt.marketing',
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


        // filter pertahun dan bulan
           $bulan = $request->bulan;
            $tahun = $request->tahun;

            if ($bulan) {
                $all = $all->filter(function ($item) use ($bulan) {
                    return \Carbon\Carbon::parse($item->created_at)->month == $bulan;
                })->values();
            }

            if ($tahun) {
                $all = $all->filter(function ($item) use ($tahun) {
                    return \Carbon\Carbon::parse($item->created_at)->year == $tahun;
                })->values();
            }



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

    // edit data
    public function update(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'jenis' => 'required',
            'nama_customer' => 'required',
        ]);

        if ($request->jenis === 'SPH') {
            DB::table('sph')
                ->where('nomor_surat', $request->nomor_surat)
                ->update([
                    'nama_customer' => $request->nama_customer,
                    'nominal' => $request->nominal,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
        }

        if ($request->jenis === 'INV') {
            DB::table('inv')
                ->where('nomor_surat', $request->nomor_surat)
                ->update([
                    'nama_customer' => $request->nama_customer,
                    'nominal' => $request->nominal,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);
        }

        if ($request->jenis === 'SKT') {
            DB::table('skt')
                ->where('nomor_surat', $request->nomor_surat)
                ->update([
                    'nama_customer' => $request->nama_customer,
                    'updated_at' => now()
                ]);
        }

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    //hapus data 
    public function destroy(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'jenis' => 'required'
        ]);

        if ($request->jenis === 'SPH') {
            DB::table('sph')->where('nomor_surat', $request->nomor_surat)->delete();
        }

        if ($request->jenis === 'INV') {
            DB::table('inv')->where('nomor_surat', $request->nomor_surat)->delete();
        }

        if ($request->jenis === 'SKT') {
            DB::table('skt')->where('nomor_surat', $request->nomor_surat)->delete();
        }

        return back()->with('success', 'Data berhasil dihapus!');
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
        ->where('sph.status', 'berhasil')
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
        ->where('inv.status', 'berhasil')
        ->get();

    $skt = DB::table('skt')
        ->join('users', 'skt.user_id', '=', 'users.user_id')
        ->select(
            'skt.user_id',
            'users.name as user_name',
            'skt.nama_customer',
            'skt.nomor_surat',
            DB::raw('NULL as nominal'),
            'skt.marketing',
            DB::raw('NULL as status'),
            'skt.created_at',
            'skt.updated_at',
            DB::raw('"SKT" as jenis')
        )
        ->get();

    $all = $sph->merge($inv)->merge($skt)->sortByDesc('created_at')->values();

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

    return Excel::download(new DaftarSuratExport($all), 'daftar-surat.xlsx');
}




}
