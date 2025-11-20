<?php

namespace App\Http\Controllers\Pimpinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // ambil keyword pencarian

        // Ambil nama customer dari SPH
        $sph = DB::table('sph')
            ->select('nama_customer')
            ->distinct()
            ->when($search, function($query, $search) {
                return $query->where('nama_customer', 'like', "%{$search}%");
            })
            ->get()
            ->map(function($item) {
                $item->jenis = ['SPH'];
                return $item;
            });

        // Ambil nama customer dari INV
        $inv = DB::table('inv')
            ->select('nama_customer')
            ->distinct()
            ->when($search, function($query, $search) {
                return $query->where('nama_customer', 'like', "%{$search}%");
            })
            ->get()
            ->map(function($item) {
                $item->jenis = ['INV'];
                return $item;
            });

        // Ambil nama customer dari SKT
        $skt = DB::table('skt')
            ->select('nama_customer')
            ->distinct()
            ->when($search, function($query, $search) {
                return $query->where('nama_customer', 'like', "%{$search}%");
            })
            ->get()
            ->map(function($item) {
                $item->jenis = ['SKT'];
                return $item;
            });

        // Gabungkan semua data
        $allCustomers = $sph->merge($inv)->merge($skt);

        // Kelompokkan berdasarkan nama_customer
        $uniqueCustomers = $allCustomers->groupBy('nama_customer')->map(function($group, $customerName) {
            $jenis = $group->pluck('jenis')->flatten()->unique()->implode(', ');
            return (object)[
                'nama_customer' => $customerName,
                'jenis' => $jenis
            ];
        })->values();

        return view('pimpinan.clients.index', compact('uniqueCustomers', 'search'));
    }
}
