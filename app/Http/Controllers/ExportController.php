<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penjualan;
use App\Models\LaporanKas;
use App\Models\RekapLebur;

class ExportController extends Controller
{
    // Penjualan Export
    public function penjualanPdf()
    {
        $records = Penjualan::latest()->get();
        $pdf = Pdf::loadView('penjualan.pdf', compact('records'));
        return $pdf->download('laporan-penjualan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function penjualanExcel()
    {
        // For simplicity, we'll stream CSV as Excel
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan-penjualan.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Tanggal', 'Invoice', 'Customer', 'Material', 'Jumlah', 'Total Harga', 'Status'];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Invoice', 'Customer', 'Material', 'Jumlah', 'Total Harga', 'Status']);

            $records = Penjualan::latest()->get();
            foreach ($records as $record) {
                fputcsv($file, [
                    $record->tanggal,
                    $record->nomor_invoice,
                    $record->customer,
                    $record->jenis_material,
                    $record->jumlah,
                    $record->total_harga,
                    $record->status_bayar
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Laporan Kas Export
    public function kasPdf()
    {
        $records = LaporanKas::latest()->get();
        $totalMasuk = LaporanKas::where('jenis', 'in')->sum('jumlah');
        $totalKeluar = LaporanKas::where('jenis', 'out')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('laporan-kas.pdf', compact('records', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
        return $pdf->download('laporan-kas-' . now()->format('Y-m-d') . '.pdf');
    }

    // Rekap Lebur Export
    public function leburPdf()
    {
        $records = RekapLebur::latest()->get();
        $pdf = Pdf::loadView('rekap-lebur.pdf', compact('records'));
        return $pdf->download('rekap-lebur-' . now()->format('Y-m-d') . '.pdf');
    }
}
