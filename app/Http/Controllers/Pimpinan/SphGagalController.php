<?php

namespace App\Http\Controllers\Pimpinan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SphGagalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // Ambil data SPH dengan join ke users
        $data = DB::table('sph_gagal')
            ->leftJoin('users', 'sph_gagal.user_id', '=', 'users.user_id')
            ->select('sph_gagal.*', 'users.name as user_name')
            ->when($search, function ($query) use ($search) {
                $query->where('sph_gagal.nama_customer', 'LIKE', "%{$search}%");
            })
            ->orderBy('sph_gagal.id', 'DESC')
            ->paginate(20) // 10 data per halaman
            ->withQueryString(); // agar search tetap ada di link pagination

        return view('pimpinan.sphgagal.index', compact('data', 'search'));
    }

    public function detail($id)
    {
        $data = DB::table('sph_gagal')
            ->leftJoin('users', 'sph_gagal.user_id', '=', 'users.user_id')
            ->select('sph_gagal.*', 'users.name as user_name')
            ->where('sph_gagal.id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }
}


