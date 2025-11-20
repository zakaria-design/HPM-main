<?php

namespace App\Http\Controllers\Pimpinan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SphProgresController extends Controller
{
      public function index(Request $request)
    {
        $search = $request->search;

        // =============================
        // DATA PROGRES (status null)
        // =============================
        $data = DB::table('progres_sph')
            ->leftJoin('users', 'progres_sph.user_id', '=', 'users.user_id')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_customer', 'LIKE', "%$search%");
            })
            ->whereNull('status')
            ->select('progres_sph.*', 'users.name as user_name') // ambil nama user
            ->get();


        // =============================
        // DATA GAGAL
        // =============================
        $gagal = DB::table('sph_gagal')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_customer', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'DESC')
            ->get();

        // =============================
        // DATA BERHASIL
        // =============================
        $berhasil = DB::table('sph')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_customer', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'DESC')
            ->get();

        return view('pimpinan.sphprogres.index', compact('data','gagal','berhasil','search'));
    }

}
