<?php

namespace App\Livewire\Manager\Dashboard;

use App\Models\Inv;
use App\Models\Skt;
use App\Models\Sph;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function render()
    {
        // Ambil user_id (string, sesuai struktur tabel)
        $userId = Auth::user()->user_id;

        // ========================
        // TOTAL SURAT
        // ========================
        $allSurat = DB::table('sph')
            ->select('nomor_surat')
            ->where('user_id', $userId)
            ->union(
                DB::table('inv')
                    ->select('nomor_surat')
                    ->where('user_id', $userId)
            )
            ->union(
                DB::table('skt')
                    ->select('nomor_surat')
                    ->where('user_id', $userId)
            )
            ->get();

        $totalSurat = $allSurat->count();

        // ========================
        // CUSTOMER UNIK (BERSIH)
        // ========================
        $sphCustomers = DB::table('sph')->where('user_id', $userId)->pluck('nama_customer');
        $invCustomers = DB::table('inv')->where('user_id', $userId)->pluck('nama_customer');
        $sktCustomers = DB::table('skt')->where('user_id', $userId)->pluck('nama_customer');

        $allCustomers = $sphCustomers
            ->merge($invCustomers)
            ->merge($sktCustomers)
            ->map(function ($name) {
                // 1️⃣ Hilangkan titik
                $clean = str_replace('.', '', $name);

                // 2️⃣ Hapus spasi di awal dan akhir
                $clean = trim($clean);

                // 3️⃣ Ganti banyak spasi jadi satu
                $clean = preg_replace('/\s+/', ' ', $clean);

                // 4️⃣ Ubah huruf kecil biar perbandingan tidak case-sensitive
                $clean = strtolower($clean);

                return $clean;
            })
            ->unique()
            ->sort()
            ->values();

        $totalCustomers = $allCustomers->count();

        // ========================
        // TOTAL PROGRES SPH
        // ========================
        $totalProgres = DB::table('progres_sph')
            ->where('user_id', $userId)
            ->count();

        // ========================
        // TOTAL SPH GAGAL
        // ========================
        $totalSphGagal = DB::table('sph_gagal')
            ->where('user_id', $userId)
            ->count();

        // ========================
        // RETURN KE VIEW
        // ========================
        return view('livewire.manager.dashboard.index', [
            'totalSurat' => $totalSurat,
            'customers' => $allCustomers,
            'totalCustomers' => $totalCustomers,
            'totalProgres' => $totalProgres,
            'totalSphGagal' => $totalSphGagal,
        ]);
    }
}
