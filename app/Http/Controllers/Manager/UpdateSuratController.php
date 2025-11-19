<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateSuratController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;

        // Data progres_sph milik user & belum diproses
        $data = DB::table('progres_sph')
            ->where('user_id', $userId)
            ->whereNull('status')
            ->get();

        // Data SPH Gagal milik user login
        $gagal = DB::table('sph_gagal')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();

        // Data SPH Berhasil (jika ingin ditampilkan juga)
        $berhasil = DB::table('sph')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();

        return view('manager.updatesurat.index', compact('data','gagal','berhasil'));
    }


    public function detail($id, $type)
    {
        $userId = Auth::user()->user_id;

        if ($type === 'sph') {
            $data = DB::table('sph')
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();
        } elseif ($type === 'sph_gagal') {
            $data = DB::table('sph_gagal')
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }



    public function gagal($id)
    {
        $userId = Auth::user()->user_id;

        $row = DB::table('progres_sph')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau bukan milik Anda');
        }

        // Cek nomor_surat unik
        $exists = DB::table('sph_gagal')->where('nomor_surat', $row->nomor_surat)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor surat sudah ada di SPH Gagal');
        }

        // Salin data ke sph_gagal
        DB::table('sph_gagal')->insert([
            'nomor_surat'   => $row->nomor_surat,
            'nama_customer' => $row->nama_customer,
            'nominal'       => $row->nominal,
            'user_id'       => $userId,         // FK ke users.user_id
            'update'        => now(),           // kolom text
            'created_at'    => $row->created_at, // tanggal asli dari progres_sph
            'updated_at'    => now(),
        ]);

        // Ubah status agar tidak muncul lagi
        DB::table('progres_sph')->where('id', $id)->update([
            'status' => 'gagal'
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditandai sebagai surat gagal');
    }

    public function berhasil($id)
    {
        $userId = Auth::user()->user_id;

        $row = DB::table('progres_sph')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$row) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau bukan milik Anda');
        }

        // Cek nomor_surat unik di tabel sph
        $exists = DB::table('sph')->where('nomor_surat', $row->nomor_surat)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Nomor surat sudah ada di SPH Berhasil');
        }

        // Salin data ke sph
        DB::table('sph')->insert([
            'nomor_surat'   => $row->nomor_surat,
            'nama_customer' => $row->nama_customer,
            'nominal'       => $row->nominal,
            'user_id'       => $userId,
            'update'        => now(),
            'created_at'    => $row->created_at,
            'updated_at'    => now(),
        ]);

        // Update status agar tidak tampil lagi
        DB::table('progres_sph')->where('id', $id)->update([
            'status' => 'berhasil'
        ]);

        return redirect()->back()->with('success', 'Data berhasil di tandai sebagai surat berhasil');
    }
}
