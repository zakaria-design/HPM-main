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

    // Ambil data SPH (ada nominal)
    $sph = DB::table('progres_sph')
        ->where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->select('nama_customer', 'nomor_surat', 'nominal', 'created_at', DB::raw('"SPH" as jenis'))
        ->get();

    // Ambil data INV (ada nominal)
    $inv = DB::table('inv')
        ->where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->select('nama_customer', 'nomor_surat', 'nominal', 'created_at', DB::raw('"INV" as jenis'))
        ->get();

    // Ambil data SKT (tidak ada nominal, jadi kita tambahkan NULL as nominal)
    $skt = DB::table('skt')
        ->where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->select('nama_customer', 'nomor_surat', DB::raw('NULL as nominal'), 'created_at', DB::raw('"SKT" as jenis'))
        ->get();

    // Gabungkan semua (ke urutan terbalik/asc sesuai kebutuhan — di sini merge sederhana)
    $pengajuanHariIni = $sph->merge($inv)->merge($skt)
        // opsional: urutkan berdasarkan created_at desc jika perlu
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

        // Mapping jenis surat => tabel + prefix
        $table = [
            'surat penawaran harga' => 'progres_sph',
            'surat invoice' => 'inv',
            'surat keterangan' => 'skt',
        ][$jenis];

        $prefix = [
            'surat penawaran harga' => 'SPH-HPM',
            'surat invoice' => 'INV-HPM',
            'surat keterangan' => 'SKT-HPM',
        ][$jenis];

        // Bulan romawi
        $romawi = [
            '01'=>'I','02'=>'II','03'=>'III','04'=>'IV','05'=>'V','06'=>'VI',
            '07'=>'VII','08'=>'VIII','09'=>'IX','10'=>'X','11'=>'XI','12'=>'XII',
        ];

        $bulan = Carbon::now()->format('m');
        $bulanRomawi = $romawi[$bulan];

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

        // Cegah customer duplikat untuk jenis surat yang sama
        $exists = DB::table($table)
            ->whereRaw("REPLACE(LOWER(nama_customer),' ','') = ?", [strtolower(str_replace(' ', '', $nama))])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Customer sudah memiliki surat jenis ini.')->withInput();
        }

        // Siapkan data insert
        $data = [
            'user_id' => Auth::user()->user_id,
            'nama_customer' => $nama,
            'nomor_surat' => $nomorSurat,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if ($jenis !== 'surat keterangan') {
            $data['nominal'] = preg_replace('/[^\d]/', '', $request->nominal);
        }

        // Insert
        DB::table($table)->insert($data);

        return redirect()->route('manager.pengajuan.index')->with('success', 'Surat berhasil dibuat!');
    }
}
