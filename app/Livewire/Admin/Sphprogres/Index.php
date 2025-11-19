<?php

namespace App\Livewire\Admin\Sphprogres;

use Carbon\Carbon;
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
    public $perPage = 20;
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

    // ✅ Fungsi untuk menyetujui data
    public function setujui($id)
    {
        $data = DB::table('progres_sph')->where('id', $id)->first();

        if ($data) {
            // Pindahkan ke tabel sph
            DB::table('sph')->insert([
                'nomor_surat' => $data->nomor_surat,
                'nama_customer' => $data->nama_customer,
                'nominal' => $data->nominal,
                'user_id' => $data->user_id,
                'update' => Carbon::now(),
                'created_at' => $data->created_at,
                'updated_at' => now(),
            ]);

            // Hapus dari progres_sph setelah dipindahkan
            DB::table('progres_sph')->where('id', $id)->delete();

            // Kirim event notifikasi ke browser
            $this->dispatch('showSuccess', message: 'Surat berhasil ditandai sebagai berhasil.');
        }
    }

    // ✅ Fungsi untuk menolak data
    public function tolak($id)
    {
        $data = DB::table('progres_sph')->where('id', $id)->first();

        if ($data) {
            // Pindahkan ke tabel sph_gagal
            DB::table('sph_gagal')->insert([
                'nomor_surat' => $data->nomor_surat,
                'nama_customer' => $data->nama_customer,
                'nominal' => $data->nominal,
                'user_id' => $data->user_id,
                'update' => Carbon::now(),
                'created_at' => $data->created_at,
                'updated_at' => now(),
            ]);

            // Hapus dari progres_sph setelah dipindahkan
            DB::table('progres_sph')->where('id', $id)->delete();

            // Kirim event notifikasi ke browser
            $this->dispatch('showSuccess', message: 'Surat berhasil ditandai sebagai gagal.');
        }
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
            ->whereNotIn('progres_sph.nomor_surat', function ($query) {
                $query->select('nomor_surat')->from('sph');
            })
            ->whereNotIn('progres_sph.nomor_surat', function ($query) {
                $query->select('nomor_surat')->from('sph_gagal');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.sphprogres.index', [
            'data' => $data
        ]);
    }
}
