<?php

namespace App\Livewire\Karyawan\Updatesurat;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ProgresSph;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedSurat = null;
    public $search = '';
    public $showAll = false;
    public $modalType = null;
    public $allData = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    //  Fungsi untuk menyetujui data
    public function setujui($id)
    {
        $data = ProgresSph::find($id);

        if ($data) {
            // pindahkan ke tabel sph
            DB::table('sph')->insert([
                'nomor_surat' => $data->nomor_surat,
                'nama_customer' => $data->nama_customer,
                'nominal' => $data->nominal,
                'user_id' => $data->user_id,
                'update' => Carbon::now(),
                 'created_at' => $data->created_at,
                'updated_at' => now(),
            ]);

            // kirim event notifikasi ke browser
            $this->dispatch('showSuccess', message: 'Surat berhasil dapat kesepakatan.');
    
        }
    }

    //  Fungsi untuk menolak data
    public function tolak($id)
    {
        $data = ProgresSph::find($id);

        if ($data) {
            // pindahkan ke tabel sph_gagal
            DB::table('sph_gagal')->insert([
                'nomor_surat' => $data->nomor_surat,
                'nama_customer' => $data->nama_customer,
                'nominal' => $data->nominal,
                'user_id' => $data->user_id,
                'update' => Carbon::now(),
                'created_at' => $data->created_at,
                'updated_at' => now(),
            ]);

            // kirim event notifikasi ke browser
            $this->dispatch('showError', message: 'Surat gagal dapat kesepakatan.');
        }
    }

    public function showDetail($id, $table)
    {
        if ($table === 'sph') {
            $this->selectedSurat = DB::table('sph')->find($id);
        } elseif ($table === 'sph_gagal') {
            $this->selectedSurat = DB::table('sph_gagal')->find($id);
        }

        $this->dispatch('showDetailModal');
    }

    public function showAllData($type)
    {
        $this->modalType = $type;

        if ($type === 'sph') {
            $this->allData = DB::table('sph')
                ->where('user_id', Auth::user()->user_id)
                ->orderBy('update', 'desc') // urut berdasarkan kolom 'update'
                ->get();
        } elseif ($type === 'sph_gagal') {
            $this->allData = DB::table('sph_gagal')
                ->where('user_id', Auth::user()->user_id)
                ->orderBy('update', 'desc') // urut berdasarkan kolom 'update'
                ->get();
        }

        $this->dispatch('showAllModal');
    }


    public function render()
{
    $data = ProgresSph::where('user_id', Auth::user()->user_id)
        ->when($this->search, function ($query) {
            $query->where('nomor_surat', 'like', '%' . $this->search . '%')
                ->orWhere('nama_customer', 'like', '%' . $this->search . '%');
        })
        // 🔽 Tambahan: filter agar nomor_surat tidak ada di sph atau sph_gagal
        ->whereNotIn('nomor_surat', function ($query) {
            $query->select('nomor_surat')->from('sph');
        })
        ->whereNotIn('nomor_surat', function ($query) {
            $query->select('nomor_surat')->from('sph_gagal');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $sphSukses = DB::table('sph')
        ->where('user_id', Auth::user()->user_id)
        ->orderBy('created_at', 'desc')
        ->get();

    $sphGagal = DB::table('sph_gagal')
        ->where('user_id', Auth::user()->user_id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('livewire.karyawan.updatesurat.index', [
        'data' => $data,
        'sphSukses' => $sphSukses,
        'sphGagal' => $sphGagal,
    ]);
}

}