<?php

namespace App\Livewire\Admin\Sphsuccess;

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
    public $perPage = 50;
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
        $this->selectedSurat = DB::table('sph')
            ->join('users', 'sph.user_id', '=', 'users.user_id')
            ->select('sph.*', 'users.name as nama_user')
            ->where('sph.id', $id)
            ->first();
    }


    public function render()
    {
        $data = DB::table('sph')
            ->join('users', 'sph.user_id', '=', 'users.user_id')
            ->select(
                'sph.*',
                'users.name as nama_user'
            )
            ->when($this->search, function ($query) {
                $query->where('sph.nomor_surat', 'like', '%' . $this->search . '%')
                      ->orWhere('sph.nama_customer', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.sphsuccess.index', [
            'data' => $data
        ]);
    }
}