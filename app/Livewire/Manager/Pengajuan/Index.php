<?php

namespace App\Livewire\Manager\Pengajuan;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{

    public $nama_customer, $jenis_surat, $nominal;

    public $dataHariIni = [];

    protected $rules = [
        'nama_customer' => 'required|string|max:255',
        'jenis_surat' => 'required|string',
        'nominal' => 'nullable|numeric|min:0',
    ];

    public function getDataHariIni()
    {
        $userId = Auth::user()->user_id;
        $today = now()->toDateString();

        // 🔹 Ambil data dari masing-masing tabel
        $progres_sph = DB::table('progres_sph')
            ->select('nomor_surat', 'nama_customer', 'nominal', 'created_at', DB::raw("'surat penawaran harga' as jenis_surat"))
            ->whereDate('created_at', $today)
            ->where('user_id', $userId);

        $inv = DB::table('inv')
            ->select('nomor_surat', 'nama_customer', 'nominal', 'created_at', DB::raw("'surat invoice' as jenis_surat"))
            ->whereDate('created_at', $today)
            ->where('user_id', $userId);

        $skt = DB::table('skt')
            ->select('nomor_surat', 'nama_customer', DB::raw('NULL as nominal'), 'created_at', DB::raw("'surat keterangan' as jenis_surat"))
            ->whereDate('created_at', $today)
            ->where('user_id', $userId);

        //  Gabungkan semua tabel
        $this->dataHariIni = $progres_sph
            ->unionAll($inv)
            ->unionAll($skt)
            ->orderBy('created_at', 'desc')
            ->get();
    }


public function save()
{
    if ($this->nominal) {
        $this->nominal = preg_replace('/[^\d]/', '', $this->nominal);
    }

    // Normalisasi nama customer (hapus spasi berlebih saja, tidak ubah huruf)
    $this->nama_customer = trim(preg_replace('/\s+/', ' ', $this->nama_customer));

    $this->validate();

    $prefix = match ($this->jenis_surat) {
        'surat penawaran harga' => 'SPH-HPM',
        'surat invoice' => 'INV-HPM',
        'surat keterangan' => 'SKT-HPM',
    };

    $table = match ($this->jenis_surat) {
        'surat penawaran harga' => 'progres_sph',
        'surat invoice' => 'inv',
        'surat keterangan' => 'skt',
    };

    $tahunSekarang = date('Y');
    $bulan = date('m');

    // Konversi bulan ke angka romawi
    $romawi = [
        '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
        '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
        '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
    ];
    $bulanRomawi = $romawi[$bulan] ?? $bulan;

    // Ambil nomor terakhir tahun ini
    $last = DB::table($table)
        ->whereYear('created_at', $tahunSekarang)
        ->latest('id')
        ->first();

    $lastNumber = 0;
    if ($last && !empty($last->nomor_surat)) {
        if (preg_match('/-(\d{1,})\//', $last->nomor_surat, $m)) {
            $lastNumber = intval($m[1]);
        }
    }

    $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    $nomorSurat = "{$prefix}-{$newNumber}/{$bulanRomawi}/{$tahunSekarang}";

    // Cek duplikat nama_customer + jenis_surat lintas user (abaikan spasi dan kapital)
    $normalizedName = strtolower(preg_replace('/\s+/', '', $this->nama_customer));

    $exists = DB::table($table)
        ->whereRaw("REPLACE(LOWER(nama_customer), ' ', '') = ?", [$normalizedName])
        ->exists();

    if ($exists) {
        $this->dispatch('showError', message: 'Gagal! Customer ini sudah memiliki surat jenis yang sama.');
        $this->reset(['nama_customer', 'jenis_surat', 'nominal']);
        return;
    }

    $user = Auth::user();

    $data = [
        'user_id' => $user->user_id,
        'nama_customer' => strtoupper($this->nama_customer), // 🔹 ubah ke huruf kapital semua
        'nomor_surat' => $nomorSurat,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    if ($this->jenis_surat !== 'surat keterangan') {
        $data['nominal'] = $this->nominal;
    }

    DB::table($table)->insert($data);

    $this->reset(['nama_customer', 'jenis_surat', 'nominal']);
    $this->dispatch('closeModal');
    $this->dispatch('showSuccess', message: 'Surat berhasil diajukan!');
}


    // tampilkan data
    public function render()
    {
        $this->getDataHariIni();
        return view('livewire.manager.pengajuan.index', [
            'dataHariIni' => $this->dataHariIni,
        ]);
    }

}

