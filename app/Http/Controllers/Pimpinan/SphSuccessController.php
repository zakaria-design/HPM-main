<?php

namespace App\Http\Controllers\Pimpinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SphSuccessController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // Ambil data SPH dengan join ke users
        $data = DB::table('sph')
            ->leftJoin('users', 'sph.user_id', '=', 'users.user_id')
            ->select('sph.*', 'users.name as user_name')
            ->when($search, function ($query) use ($search) {
                $query->where('sph.nama_customer', 'LIKE', "%{$search}%");
            })
            ->orderBy('sph.id', 'DESC')
            ->paginate(20) // 10 data per halaman
            ->withQueryString(); // agar search tetap ada di link pagination

        return view('pimpinan.sphsuccess.index', compact('data', 'search'));
    }

    public function detail($id)
    {
        $data = DB::table('sph')
            ->leftJoin('users', 'sph.user_id', '=', 'users.user_id')
            ->select('sph.*', 'users.name as user_name')
            ->where('sph.id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }
}

