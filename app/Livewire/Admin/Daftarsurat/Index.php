<?php

namespace App\Livewire\Admin\Daftarsurat;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $kategori = 'semua';
    public $jenis = 'semua'; 
    public $selectedSurat = null;

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

    public function showDetail($nomorSurat, $jenisSurat)
    {
        $table = match ($jenisSurat) {
            'surat penawaran harga' => 'sph',
            'surat invoice' => 'inv',
            'surat keterangan' => 'skt',
            default => null,
        };

        if ($table) {
            $this->selectedSurat = DB::table($table)
                ->select('*', DB::raw("'" . $jenisSurat . "' as jenis_surat")) 
                ->where('nomor_surat', $nomorSurat)
                ->first();
        } else {
            $this->selectedSurat = null;
        }

        $this->dispatch('show-detail-modal');
    }

    public function render()
    {
        // Hapus filter berdasarkan user_id agar semua data tampil
        $sph = DB::table('sph')
            ->select(
                'id',
                'nomor_surat',
                'nama_customer',
                'nominal',
                'created_at',
                DB::raw("'surat penawaran harga' as jenis_surat")
            );

        $inv = DB::table('inv')
            ->select(
                'id',
                'nomor_surat',
                'nama_customer',
                'nominal',
                'created_at',
                DB::raw("'surat invoice' as jenis_surat")
            );

        $skt = DB::table('skt')
            ->select(
                'id',
                'nomor_surat',
                'nama_customer',
                DB::raw('NULL as nominal'),
                'created_at',
                DB::raw("'surat keterangan' as jenis_surat")
            );

        // Satukan semua data surat dari 3 tabel
        $unionQuery = $sph->unionAll($inv)->unionAll($skt);

        // Bungkus hasil union agar bisa di-filter
        $query = DB::query()
            ->fromSub($unionQuery, 'daftar_surat')
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if (!empty($this->search)) {
            $query->where('nama_customer', 'like', '%' . $this->search . '%');
        }

        // Filter kategori (perusahaan / perorangan)
        if ($this->kategori === 'perusahaan') {
            $query->whereRaw("LOWER(nama_customer) REGEXP '(^|\\s)(pt|cv|ud|firma)'");
        } elseif ($this->kategori === 'perorangan') {
            $query->whereRaw("LOWER(nama_customer) NOT REGEXP '(^|\\s)(pt|cv|ud|firma)'");
        }

        // Filter jenis surat (jika dipilih)
        if ($this->jenis !== 'semua') {
            $query->where('jenis_surat', $this->jenis);
        }

        $dataSurat = $query->paginate(50);

        return view('livewire.admin.daftarsurat.index', [
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
