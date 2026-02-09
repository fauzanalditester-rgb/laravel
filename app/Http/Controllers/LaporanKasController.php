<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\LaporanKas::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('keterangan', 'like', "%$search%")
                    ->orWhere('kategori', 'like', "%$search%");
            })
            ->when($request->jenis, function ($query, $jenis) {
                $query->where('jenis', $jenis);
            })
            ->latest('tanggal')
            ->latest('id')
            ->paginate(20);

        $totalMasuk = \App\Models\LaporanKas::where('jenis', 'in')->sum('jumlah');
        $totalKeluar = \App\Models\LaporanKas::where('jenis', 'out')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        return view('laporan-kas.index', compact('records', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
    }

    public function create()
    {
        return view('laporan-kas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:in,out',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Calculate latest saldo
        $lastRecord = \App\Models\LaporanKas::latest('id')->first();
        $lastSaldo = $lastRecord ? $lastRecord->saldo : 0;

        $currentSaldo = ($request->jenis == 'in')
            ? $lastSaldo + $request->jumlah
            : $lastSaldo - $request->jumlah;

        \App\Models\LaporanKas::create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'saldo' => $currentSaldo,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('laporan-kas.index')->with('success', 'Transaksi kas berhasil dicatat.');
    }

    public function destroy(\App\Models\LaporanKas $laporanKas)
    {
        $laporanKas->delete();
        // Note: In real scenarios, deleting an item in the middle of a ledger requires recalculating all subsequent saldos.
        // For this MVP, we'll just soft delete.
        return redirect()->route('laporan-kas.index')->with('success', 'Data kas berhasil dihapus.');
    }
}
