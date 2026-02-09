<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\PengajuanKas::with(['creator', 'approver'])
            ->when($request->search, function ($query, $search) {
                $query->where('keperluan', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('pengajuan-kas.index', compact('records'));
    }

    public function create()
    {
        return view('pengajuan-kas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        \App\Models\PengajuanKas::create([
            'tanggal' => $request->tanggal,
            'keperluan' => $request->keperluan,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('pengajuan-kas.index')->with('success', 'Pengajuan kas berhasil dikirim.');
    }

    public function edit(\App\Models\PengajuanKas $pengajuanKa)
    {
        if ($pengajuanKa->status !== 'pending') {
            return redirect()->route('pengajuan-kas.index')->with('error', 'Hanya pengajuan pending yang dapat diubah.');
        }
        return view('pengajuan-kas.edit', ['record' => $pengajuanKa]);
    }

    public function update(Request $request, \App\Models\PengajuanKas $pengajuanKa)
    {
        if ($pengajuanKa->status !== 'pending') {
            return redirect()->route('pengajuan-kas.index')->with('error', 'Hanya pengajuan pending yang dapat diubah.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'keperluan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $pengajuanKa->update($request->only('tanggal', 'keperluan', 'jumlah', 'keterangan'));

        return redirect()->route('pengajuan-kas.index')->with('success', 'Pengajuan kas berhasil diperbarui.');
    }

    public function destroy(\App\Models\PengajuanKas $pengajuanKa)
    {
        if ($pengajuanKa->status !== 'pending') {
            return redirect()->route('pengajuan-kas.index')->with('error', 'Hanya pengajuan pending yang dapat dihapus.');
        }
        $pengajuanKa->delete();
        return redirect()->route('pengajuan-kas.index')->with('success', 'Pengajuan kas berhasil dihapus.');
    }

    public function approve(\App\Models\PengajuanKas $pengajuanKa)
    {
        $pengajuanKa->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('pengajuan-kas.index')->with('success', 'Pengajuan kas disetujui.');
    }

    public function reject(\App\Models\PengajuanKas $pengajuanKa)
    {
        $pengajuanKa->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('pengajuan-kas.index')->with('success', 'Pengajuan kas ditolak.');
    }
}
