<?php

namespace App\Livewire\Pimpinan\Sphgagal;

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

   public function showDetailSuccess($id)
    {
        $this->selectedSurat = DB::table('sph_gagal')
            ->join('users', 'sph_gagal.user_id', '=', 'users.user_id')
            ->select('sph_gagal.*', 'users.name as nama_user')
            ->where('sph_gagal.id', $id)
            ->first();
    }


    public function render()
    {
        $data = DB::table('sph_gagal')
            ->join('users', 'sph_gagal.user_id', '=', 'users.user_id')
            ->select(
                'sph_gagal.*',
                'users.name as nama_user'
            )
            ->when($this->search, function ($query) {
                $query->where('sph_gagal.nomor_surat', 'like', '%' . $this->search . '%')
                      ->orWhere('sph_gagal.nama_customer', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.pimpinan.sphgagal.index', [
            'data' => $data
        ]);
    }
}