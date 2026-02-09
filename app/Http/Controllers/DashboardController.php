<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\LaporanKas;
use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\RekapTimbangan;

class DashboardController extends Controller
{
    public function index()
    {
        $total_penjualan = Penjualan::where('status_bayar', 'paid')->sum('total_harga') + Penjualan::where('status_bayar', 'partial')->sum('total_harga'); // Simple sum
        $total_kas = LaporanKas::latest('id')->first()?->saldo ?? 0;
        $total_hutang = Hutang::where('status', 'belum_lunas')->sum('jumlah');
        $total_piutang = Piutang::where('status', 'belum_lunas')->sum('jumlah');

        // Recent Transactions
        $recent_penjualan = Penjualan::latest('created_at')->take(5)->get();
        $recent_kas = LaporanKas::latest('created_at')->take(5)->get();

        // Chart Data (Example: Monthly Sales for last 6 months)
        $salesData = Penjualan::selectRaw('MONTH(tanggal) as month, SUM(total_harga) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartValues = [];
        foreach (range(1, 12) as $m) {
            $chartValues[] = $salesData[$m] ?? 0;
        }

        // Anomaly Detection: High Shrinkage (>10%)
        $anomalyCount = \App\Models\RekapLebur::whereRaw('(susut / berat_awal) * 100 > 10')->count();

        return view('dashboard', compact(
            'total_penjualan',
            'total_kas',
            'total_hutang',
            'total_piutang',
            'recent_penjualan',
            'recent_kas',
            'chartLabels',
            'chartValues',
            'anomalyCount'
        ));
    }
}
