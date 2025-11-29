<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengajuanController extends Controller
{
   public function index()
        {
            $userId = Auth::user()->user_id;
            $today = Carbon::today();

            // SPH
            $sph = DB::table('sph')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select(
                    'id',
                    'nama_customer',
                    'nomor_surat',
                    'nominal',
                    'created_at',
                    DB::raw('"SPH" as jenis'),
                    DB::raw('"sph" as sumber_tabel')
                )
                ->get();

            // INV
            $inv = DB::table('inv')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select(
                    'id',
                    'nama_customer',
                    'nomor_surat',
                    'nominal',
                    'created_at',
                    DB::raw('"INV" as jenis'),
                    DB::raw('"inv" as sumber_tabel')
                )
                ->get();

            // SKT
            $skt = DB::table('skt')
                ->where('user_id', $userId)
                ->whereDate('created_at', $today)
                ->select(
                    'id',
                    'nama_customer',
                    'nomor_surat',
                    DB::raw('NULL as nominal'),
                    'created_at',
                    DB::raw('"SKT" as jenis'),
                    DB::raw('"skt" as sumber_tabel')
                )
                ->get();

            // Gabungkan
            $pengajuanHariIni = $sph->merge($inv)->merge($skt)
                ->sortByDesc('created_at')
                ->values();

            return view('manager.pengajuan.index', [
                'jenis_surat' => [
                    'surat penawaran harga',
                    'surat invoice',
                    'surat keterangan'
                ],
                'pengajuanHariIni' => $pengajuanHariIni,
            ]);
        }



    public function store(Request $request)
        {
            $request->validate([
                'nama_customer' => 'required|string|max:255',
                'jenis_surat' => 'required',
                'nominal' => $request->jenis_surat !== 'surat keterangan' 
                                ? 'required' 
                                : 'nullable',
            ]);

            $nama = strtoupper(trim($request->nama_customer));
            $jenis = $request->jenis_surat;
            $userId = Auth::user()->user_id;

            // Mapping tabel & prefix
            $table = [
                'surat penawaran harga' => 'sph',
                'surat invoice' => 'inv',
                'surat keterangan' => 'skt',
            ][$jenis];

            $prefix = [
                'surat penawaran harga' => 'SPH-HPM',
                'surat invoice' => 'INV-HPM',
                'surat keterangan' => 'SKT-HPM',
            ][$jenis];

            // Format nomor surat
            $romawi = [
                '01'=>'I','02'=>'II','03'=>'III','04'=>'IV','05'=>'V','06'=>'VI',
                '07'=>'VII','08'=>'VIII','09'=>'IX','10'=>'X','11'=>'XI','12'=>'XII',
            ];

            $bulanRomawi = $romawi[Carbon::now()->format('m')];
            $tahun = Carbon::now()->year;

            // Ambil nomor terakhir tahun ini
            $last = DB::table($table)
                ->whereYear('created_at', $tahun)
                ->orderBy('id', 'desc')
                ->first();

            $lastNumber = 0;

            if ($last && preg_match('/-(\d+)\//', $last->nomor_surat, $m)) {
                $lastNumber = (int)$m[1];
            }

            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $nomorSurat = "{$prefix}-{$newNumber}/{$bulanRomawi}/{$tahun}";

            // ================================
            // 🔍 CEK DUPLIKASI CUSTOMER
            // ================================

            // Hilangkan spasi & case-insensitive
            $normalizedName = strtolower(str_replace(' ', '', $nama));

            // Cek apakah customer ini sudah ada dan dibuat user lain
            $existing = DB::table($table)
                ->whereRaw("REPLACE(LOWER(nama_customer),' ','') = ?", [$normalizedName])
                ->first();

            if ($existing && $existing->user_id !== $userId) {
                return back()->with('error', '❌ Customer ini sudah ditangani user lain!')->withInput();
            }

            // ================================
            // SIMPAN DATA
            // ================================
            $data = [
                'user_id' => $userId,
                'nama_customer' => $nama,
                'nomor_surat' => $nomorSurat,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if ($jenis !== 'surat keterangan') {
                $data['nominal'] = preg_replace('/[^\d]/', '', $request->nominal);
            }

            DB::table($table)->insert($data);

            return redirect()->route('manager.pengajuan.index')->with('success', 'Surat berhasil dibuat!');
        }

    public function update(Request $request, $tabel, $id)
        {
            $data = [
                'nama_customer' => $request->nama_customer,
                'nomor_surat'   => $request->nomor_surat
            ];

            // Jika tabel adalah sph atau inv → mereka punya kolom nominal
            if (in_array($tabel, ['sph', 'inv'])) {
                $data['nominal'] = $request->nominal;
            }

            // Jika tabel SKT → tidak ada kolom nominal, jadi jangan update nominal
            DB::table($tabel)->where('id', $id)->update($data);

            return back()->with('success', 'Data berhasil diperbarui');
        }


    public function delete($tabel, $id)
    {
        DB::table($tabel)->where('id', $id)->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }


}
