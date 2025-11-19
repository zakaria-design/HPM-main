<?php

namespace App\Livewire\Admin\Dashboard;

use Carbon\Carbon;
use App\Models\Inv;
use App\Models\Skt;
use Livewire\Component;
use App\Models\ProgresSph;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public function render()
    {
        // ===============================
        // Ambil data masing-masing tabel
        // ===============================
        $sph = DB::table('sph')->select('nama_customer','nomor_surat','created_at');
        $inv = DB::table('inv')->select('nama_customer','nomor_surat','created_at');
        $skt = DB::table('skt')->select('nama_customer','nomor_surat','created_at');

        // ===============================
        // Hitung jumlah surat masing-masing tabel
        // ===============================
        $sphCount = $sph->count();
        $invCount = $inv->count();
        $sktCount = $skt->count();

        // ===============================
        // Gabungkan semua data
        // ===============================
        $allData = $sph->unionAll($inv)->unionAll($skt)->get();

        // ===============================
        // Hitung jumlah client unik
        // ===============================
        $uniqueClientCount = $allData->pluck('nama_customer')->unique()->count();

        // ===============================
        // Hitung jumlah surat sph gagal
        // ===============================
        $gagal = DB::table('sph_gagal')->count();

        // ===============================
        // Hitung surat hari ini masing-masing tabel (progres_sph, inv, skt)
        // ===============================
        $today = Carbon::today();

        $invTodayCount = DB::table('inv')->whereDate('created_at', $today)->count();
        $sktTodayCount = DB::table('skt')->whereDate('created_at', $today)->count();
        $progresSphTodayCount = DB::table('progres_sph')->whereDate('created_at', $today)->count();

        
        // ===============================
        // ambil surat hari ini 
        // ===============================

        $today = Carbon::today();

         $invToday = Inv::with('user')
            ->whereDate('created_at', $today)
            ->get()
            ->map(function($item){
                $item->jenis_surat = 'INV';
                return $item;
            });

        $sktToday = Skt::with('user')
            ->whereDate('created_at', $today)
            ->get()
            ->map(function($item){
                $item->jenis_surat = 'SKT';
                return $item;
            });

        $progresSphToday = ProgresSph::with('user')
            ->whereDate('created_at', $today)
            ->get()
            ->map(function($item){
                $item->jenis_surat = 'SPH';
                return $item;
            });


        // gabungkan ketiganya
        $allToday = $invToday->concat($sktToday)->concat($progresSphToday);

        return view('livewire.admin.dashboard.index', [
            'uniqueClientCount' => $uniqueClientCount,
            'gagal' => $gagal,
            'sphCount' => $sphCount,
            'invCount' => $invCount,
            'sktCount' => $sktCount,
            'invTodayCount' => $invTodayCount,
            'sktTodayCount' => $sktTodayCount,
            'progresSphTodayCount' => $progresSphTodayCount,
            'allToday' => $allToday,
        ]);
    }
}