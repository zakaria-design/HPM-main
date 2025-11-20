<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UpdateSuratController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // =============================
        // DATA PROGRES (status null)
        // =============================
        $data = DB::table('progres_sph')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_customer', 'LIKE', "%$search%");
            })
            ->whereNull('status')
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

        return view('admin.sphprogres.index', compact('data','gagal','berhasil','search'));
    }


    // public function detail($id, $type)
    // {
    //     if ($type === 'sph') {
    //         $data = DB::table('sph')
    //             ->where('id', $id)
    //             ->first();
    //     } elseif ($type === 'sph_gagal') {
    //         $data = DB::table('sph_gagal')
    //             ->where('id', $id)
    //             ->first();
    //     } else {
    //         return response()->json(['error' => 'Invalid type'], 400);
    //     }

    //     if (!$data) {
    //         return response()->json(['error' => 'Data tidak ditemukan'], 404);
    //     }

    //     return response()->json($data);
    // }



    public function gagal($id)
    {
        // Ambil data TANPA FILTER user_id
        $row = DB::table('progres_sph')
            ->where('id', $id)
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Cek nomor_surat unik
        $exists = DB::table('sph_gagal')->where('nomor_surat', $row->nomor_surat)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor surat sudah ada di SPH Gagal');
        }

        DB::table('sph_gagal')->insert([
            'nomor_surat'   => $row->nomor_surat,
            'nama_customer' => $row->nama_customer,
            'nominal'       => $row->nominal,
            'user_id'       => $row->user_id, 
            'update'        => now(),
            'created_at'    => $row->created_at,
            'updated_at'    => now(),
        ]);

        DB::table('progres_sph')->where('id', $id)->update([
            'status' => 'gagal'
        ]);

        return redirect()->back()->with('success', 'Berhasil ditandai sebagai gagal');
    }


    public function berhasil($id)
    {
        $row = DB::table('progres_sph')
            ->where('id', $id)
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Cek nomor unik
        $exists = DB::table('sph')->where('nomor_surat', $row->nomor_surat)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor surat sudah ada di SPH Berhasil');
        }

        DB::table('sph')->insert([
            'nomor_surat'   => $row->nomor_surat,
            'nama_customer' => $row->nama_customer,
            'nominal'       => $row->nominal,
            'user_id'       => $row->user_id,
            'update'        => now(),
            'created_at'    => $row->created_at,
            'updated_at'    => now(),
        ]);

        DB::table('progres_sph')->where('id', $id)->update([
            'status' => 'berhasil'
        ]);

        return redirect()->back()->with('success', 'Berhasil ditandai sebagai surat berhasil');
    }
}
