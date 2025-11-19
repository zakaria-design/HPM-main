<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Absen;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class HapusFotoAbsen extends Command
{
    protected $signature = 'absen:hapus-foto';
    protected $description = 'Hapus foto dan bukti absen yang lebih dari 3 hari';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tanggalLimit = Carbon::now()->subDays(3);

        $absens = Absen::where('waktu', '<', $tanggalLimit)->get();

        foreach ($absens as $absen) {
            // hapus kolom foto
            if ($absen->foto && File::exists(public_path('absen/' . $absen->foto))) {
                File::delete(public_path('absen/' . $absen->foto));
                $this->info('Foto absen dihapus: ' . $absen->foto);
                $absen->foto = null;
            }

            // hapus kolom foto_bukti
            if ($absen->foto_bukti && File::exists(public_path('absen/' . $absen->foto_bukti))) {
                File::delete(public_path('absen/' . $absen->foto_bukti));
                $this->info('Foto bukti dihapus: ' . $absen->foto_bukti);
                $absen->foto_bukti = null;
            }

            $absen->save();
        }

        $this->info('Proses hapus foto selesai.');
    }
}
