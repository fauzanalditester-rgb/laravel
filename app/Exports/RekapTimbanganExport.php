<?php

namespace App\Exports;

use App\Models\RekapTimbangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapTimbanganExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RekapTimbangan::with('creator')->latest('tanggal')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'No. Kendaraan',
            'Jenis Material',
            'Berat Masuk (Kg)',
            'Berat Keluar (Kg)',
            'Berat Bersih (Kg)',
            'Keterangan',
            'Dibuat Oleh',
        ];
    }

    public function map($rekap): array
    {
        return [
            $rekap->id,
            $rekap->tanggal,
            $rekap->nomor_kendaraan,
            $rekap->jenis_material,
            $rekap->berat_masuk,
            $rekap->berat_keluar,
            $rekap->berat_bersih,
            $rekap->keterangan,
            $rekap->creator->name ?? '-',
        ];
    }
}
