<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratGagalController extends Controller
{
   public function index(Request $request)
{
    $userId = Auth::user()->user_id;

    $jenis  = $request->get('jenis', 'semua');
    $search = $request->get('search');

    // =========================
    // INV
    // =========================
    $inv = DB::table('inv')
        ->select('id','nomor_surat','nama_customer','status','nominal','updated_at', DB::raw("'INV' as jenis_surat"))
        ->where('user_id', $userId)
        ->where('status', 'gagal');

    if ($search) {
        $inv->where('nama_customer', 'like', "%$search%");
    }

    if ($jenis == 'INV') {
        $data = $inv->orderBy('created_at','desc')
                    ->paginate(10)
                    ->appends($request->query());
        return view('manager.suratgagal.index', compact('data','jenis','search'));
    }

    // =========================
    // SPH
    // =========================
    $sph = DB::table('sph')
        ->select('id','nomor_surat','nama_customer','status','nominal','updated_at', DB::raw("'SPH' as jenis_surat"))
        ->where('user_id', $userId)
        ->where('status', 'gagal');

    if ($search) {
        $sph->where('nama_customer', 'like', "%$search%");
    }

    if ($jenis == 'SPH') {
        $data = $sph->orderBy('created_at','desc')
                    ->paginate(10)
                    ->appends($request->query());
        return view('manager.suratgagal.index', compact('data','jenis','search'));
    }

    // =========================
    // SEMUA (UNION + PAGINATE)
    // =========================
    $unionQuery = $inv->unionAll($sph);

    // Bungkus union sebagai table baru agar bisa paginate
    $data = DB::query()
        ->fromSub($unionQuery, 'u')
        ->orderBy('updated_at', 'desc')
        ->paginate(20)
        ->appends($request->query());

    return view('manager.suratgagal.index', compact('data','jenis','search'));
}




    // =====================
    // UPDATE DATA SURAT
    // =====================
    public function update(Request $request)
{
    $request->validate([
        'id' => 'required',
        'jenis_surat' => 'required',
        'nama_customer' => 'required',
        'nominal' => 'required|numeric',
        'status' => 'nullable',  // ← BUKAN required
    ]);

    $table = strtolower($request->jenis_surat); // inv / sph

    // Jika status kosong → NULL
    $status = $request->status === "" ? null : $request->status;

    DB::table($table)->where('id', $request->id)->update([
        'nama_customer' => $request->nama_customer,
        'nominal' => $request->nominal,
        'status'      => $status,
    ]);

    return back()->with('success', 'Data berhasil diperbarui.');
}


    // =====================
    // HAPUS DATA SURAT
    // =====================
    public function delete(Request $request)
    {
        $table = strtolower($request->jenis_surat);

        DB::table($table)->where('id', $request->id)->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
