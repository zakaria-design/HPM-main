<?php

namespace App\Livewire\Manager\Daftarsurat;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $kategori = 'semua';
    public $jenis = 'semua'; // 🔹 Tambahan: filter jenis surat

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKategori()
    {
        $this->resetPage();
    }

    public function updatingJenis()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::user()->user_id;

        $sph = DB::table('sph')
            ->select(
                'nomor_surat',
                'nama_customer',
                'nominal',
                'created_at',
                DB::raw("'surat penawaran harga' as jenis_surat")
            )
            ->where('user_id', $userId);

        $inv = DB::table('inv')
            ->select(
                'nomor_surat',
                'nama_customer',
                'nominal',
                'created_at',
                DB::raw("'surat invoice' as jenis_surat")
            )
            ->where('user_id', $userId);

        $skt = DB::table('skt')
            ->select(
                'nomor_surat',
                'nama_customer',
                DB::raw('NULL as nominal'),
                'created_at',
                DB::raw("'surat keterangan' as jenis_surat")
            )
            ->where('user_id', $userId);

        // 🔹 simpan hasil union dalam subquery agar kolom alias bisa difilter
        $unionQuery = $sph->unionAll($inv)->unionAll($skt);

        // 🔧 ubah cara membungkus hasil union
        $query = DB::query()
            ->fromSub($unionQuery, 'daftar_surat') // ⬅️ pakai fromSub, bukan raw SQL
            ->orderBy('created_at', 'desc');

        // 🔍 Filter pencarian
        if (!empty($this->search)) {
            $query->where('nama_customer', 'like', '%' . $this->search . '%');
        }

        // 🏷️ Filter kategori
        if ($this->kategori === 'perusahaan') {
            $query->whereRaw("LOWER(nama_customer) REGEXP '(^|\\s)(pt|cv|ud|firma)'");
        } elseif ($this->kategori === 'perorangan') {
            $query->whereRaw("LOWER(nama_customer) NOT REGEXP '(^|\\s)(pt|cv|ud|firma)'");
        }

        // 📄 Filter jenis surat
        if ($this->jenis !== 'semua') {
            $query->where('jenis_surat', $this->jenis);
        }

        $dataSurat = $query->paginate(50);

        return view('livewire.manager.daftarsurat.index', [
            'dataSurat' => $dataSurat,
        ]);
    }

    public function exportPdf()
    {
        return redirect()->route('daftarsurat.exportPdf', [
            'search' => $this->search,
            'kategori' => $this->kategori,
            'jenis' => $this->jenis,
        ]);
    }

}
