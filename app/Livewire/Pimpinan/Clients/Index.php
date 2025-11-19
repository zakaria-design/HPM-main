<?php

namespace App\Livewire\Pimpinan\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
{
    // Ambil data dari ketiga tabel
    $sph = DB::table('sph')->select('nama_customer', DB::raw("'SPH' as jenis_surat"));
    $inv = DB::table('inv')->select('nama_customer', DB::raw("'INV' as jenis_surat"));
    $skt = DB::table('skt')->select('nama_customer', DB::raw("'SKT' as jenis_surat"));

    $allData = $sph->unionAll($inv)->unionAll($skt)->get();

    if (!empty($this->search)) {
        $allData = $allData->filter(fn($item) => stripos($item->nama_customer, $this->search) !== false);
    }

    $grouped = collect($allData)->groupBy('nama_customer')->map(function($items, $nama){
        return [
            'nama_customer' => $nama,
            'jenis_surat' => $items->pluck('jenis_surat')->toArray(),
        ];
    })->values();

    // 🔹 Custom paginate untuk Livewire
    $page = Paginator::resolveCurrentPage(); // ambil page Livewire
    $paginated = new LengthAwarePaginator(
        $grouped->forPage($page, $this->perPage),
        $grouped->count(),
        $this->perPage,
        $page,
        ['path' => Paginator::resolveCurrentPath()]
    );

    return view('livewire.pimpinan.clients.index', [
        'clients' => $paginated
    ]);
}
}