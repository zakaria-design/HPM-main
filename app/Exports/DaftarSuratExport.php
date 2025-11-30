<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DaftarSuratExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($i) {
            return [
                'Nama User'     => $i->user_name,
                'Jenis'         => $i->jenis,
                'Nama Customer' => $i->nama_customer,
                'Nomor Surat'   => $i->nomor_surat,
                'Nominal'       => $i->nominal,
                'Status'        => $i->status ?? '-',
                'Dibuat'        => $i->created_at,
                'Update Terakhir' => $i->updated_at ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama User',
            'Jenis Surat',
            'Nama Customer',
            'Nomor Surat',
            'Nominal',
            'Status',
            'Tanggal Dibuat',
            'Update Terakhir'
        ];
    }
    
}
