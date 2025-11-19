<?php

namespace App\Livewire\Pimpinan\Sphprogres;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 5;
    public $selectedSurat = null;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

   public function showDetail($id)
    {
        $this->selectedSurat = DB::table('progres_sph')
            ->join('users', 'progres_sph.user_id', '=', 'users.user_id')
            ->select('progres_sph.*', 'users.name as nama_user')
            ->where('progres_sph.id', $id)
            ->first();
    }


   public function render()
{
    $data = DB::table('progres_sph')
        ->join('users', 'progres_sph.user_id', '=', 'users.user_id')
        ->select(
            'progres_sph.*',
            'users.name as nama_user'
        )
        ->when($this->search, function ($query) {
            $query->where('progres_sph.nomor_surat', 'like', '%' . $this->search . '%')
                  ->orWhere('progres_sph.nama_customer', 'like', '%' . $this->search . '%')
                  ->orWhere('users.name', 'like', '%' . $this->search . '%');
        })
        // 🔽 Tambahan: jangan tampilkan jika nomor_surat sudah ada di sph atau sph_gagal
        ->whereNotIn('progres_sph.nomor_surat', function ($query) {
            $query->select('nomor_surat')->from('sph');
        })
        ->whereNotIn('progres_sph.nomor_surat', function ($query) {
            $query->select('nomor_surat')->from('sph_gagal');
        })
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate($this->perPage);

    return view('livewire.pimpinan.sphprogres.index', [
        'data' => $data
    ]);
}

}
