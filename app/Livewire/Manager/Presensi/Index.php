<?php

namespace App\Livewire\Manager\Presensi;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Hadir;
use App\Models\Izin;
use App\Models\Sakit;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public $hadir;
    public $izin;
    public $sakit;
    public $messageHadir;
    public $messageIzin;
    public $messageSakit;

    public function mount()
    {
        $this->loadPresensi();
    }

    public function loadPresensi()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // Hadir
        $this->hadir = Hadir::where('user_id', $userId)
            ->whereDate('waktu', $today)
            ->get();
        $this->messageHadir = $this->hadir->isEmpty() ? 'Anda belum melakukan presensi hadir hari ini.' : null;

        // Izin
        $this->izin = Izin::where('user_id', $userId)
            ->whereDate('waktu', $today)
            ->get();
        $this->messageIzin = $this->izin->isEmpty() ? 'Anda belum melakukan presensi izin hari ini.' : null;

        // Sakit
        $this->sakit = Sakit::where('user_id', $userId)
            ->whereDate('waktu', $today)
            ->get();
        $this->messageSakit = $this->sakit->isEmpty() ? 'Anda belum melakukan presensi sakit hari ini.' : null;
    }

    // Presensi Hadir
    public function presensiHadir($fotoBase64, $latitude, $longitude)
    {
        $userId = Auth::id();
        $today = Carbon::today();

        if (Hadir::where('user_id', $userId)->whereDate('waktu', $today)->exists()) {
            $this->dispatch('alert', ['message' => 'Anda sudah melakukan presensi hadir hari ini.']);
            return;
        }

        $fotoName = $this->saveFoto($fotoBase64);

        $alamat = $this->getAlamat($latitude, $longitude);

        Hadir::create([
            'user_id'   => $userId,
            'foto'      => $fotoName,
            'latitude'  => $latitude,
            'longitude' => $longitude,
            'alamat'    => $alamat,
            'waktu'     => now(),
            'jam'       => now()->toTimeString(),
        ]);

        $this->loadPresensi();
        $this->dispatch('alert', ['message' => 'Presensi hadir berhasil!']);
    }

    // Presensi Izin
    public function presensiIzin($alasan, $fotoBukti = null)
    {
        $userId = Auth::id();
        $today = Carbon::today();

        if (Izin::where('user_id', $userId)->whereDate('waktu', $today)->exists()) {
            $this->dispatch('alert', ['message' => 'Anda sudah melakukan presensi izin hari ini.']);
            return;
        }

        $fotoName = null;
        if ($fotoBukti) {
            $fotoName = $this->saveFoto($fotoBukti);
        }

        Izin::create([
            'user_id' => $userId,
            'alasan_izin' => $alasan,
            'foto_bukti' => $fotoName,
            'waktu' => now(),
            'jam' => now()->toTimeString(),
        ]);

        $this->loadPresensi();
        $this->dispatch('alert', ['message' => 'Presensi izin berhasil!']);
    }

    // Presensi Sakit
    public function presensiSakit($alasan, $fotoBukti = null)
    {
        $userId = Auth::id();
        $today = Carbon::today();

        if (Sakit::where('user_id', $userId)->whereDate('waktu', $today)->exists()) {
            $this->dispatch('alert', ['message' => 'Anda sudah melakukan presensi sakit hari ini.']);
            return;
        }

        $fotoName = null;
        if ($fotoBukti) {
            $fotoName = $this->saveFoto($fotoBukti);
        }

        Sakit::create([
            'user_id' => $userId,
            'alasan_sakit' => $alasan,
            'foto_bukti' => $fotoName,
            'waktu' => now(),
            'jam' => now()->toTimeString(),
        ]);

        $this->loadPresensi();
        $this->dispatch('alert', ['message' => 'Presensi sakit berhasil!']);
    }

    // Fungsi bantu simpan foto base64
    private function saveFoto($fotoBase64)
    {
        $fotoData = str_replace('data:image/png;base64,', '', $fotoBase64);
        $fotoData = str_replace(' ', '+', $fotoData);
        $fotoName = 'absen_' . time() . '.png';
        File::put(public_path('absen/' . $fotoName), base64_decode($fotoData));
        return $fotoName;
    }

    // Fungsi bantu ambil alamat dari koordinat
    private function getAlamat($lat, $lng)
    {
        $response = Http::get("https://nominatim.openstreetmap.org/reverse", [
            'lat' => $lat,
            'lon' => $lng,
            'format' => 'json',
            'addressdetails' => 1,
        ]);
        $data = $response->json();
        return $data['display_name'] ?? 'Alamat tidak ditemukan';
    }

    public function render()
    {
        $absens = $this->hadir->merge($this->izin)->merge($this->sakit);
        return view('livewire.manager.presensi.index', compact('absens'));
    }

}