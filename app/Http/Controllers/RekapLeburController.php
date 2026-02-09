<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapLeburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\RekapLebur::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('jenis_material', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('rekap-lebur.index', compact('records'));
    }

    public function create()
    {
        return view('rekap-lebur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_material' => 'required|string',
            'berat_awal' => 'required|numeric|min:0',
            'berat_hasil' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $susut = $request->berat_awal - $request->berat_hasil;
        $persentase_susut = ($request->berat_awal > 0) ? ($susut / $request->berat_awal) * 100 : 0;

        \App\Models\RekapLebur::create([
            'tanggal' => $request->tanggal,
            'jenis_material' => $request->jenis_material,
            'berat_awal' => $request->berat_awal,
            'berat_hasil' => $request->berat_hasil,
            'susut' => $susut,
            'persentase_susut' => $persentase_susut,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('rekap-lebur.index')->with('success', 'Data rekap lebur berhasil dicatat.');
    }

    public function edit(\App\Models\RekapLebur $rekapLebur)
    {
        return view('rekap-lebur.edit', ['record' => $rekapLebur]);
    }

    public function update(Request $request, \App\Models\RekapLebur $rekapLebur)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_material' => 'required|string',
            'berat_awal' => 'required|numeric|min:0',
            'berat_hasil' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $susut = $request->berat_awal - $request->berat_hasil;
        $persentase_susut = ($request->berat_awal > 0) ? ($susut / $request->berat_awal) * 100 : 0;

        $rekapLebur->update([
            'tanggal' => $request->tanggal,
            'jenis_material' => $request->jenis_material,
            'berat_awal' => $request->berat_awal,
            'berat_hasil' => $request->berat_hasil,
            'susut' => $susut,
            'persentase_susut' => $persentase_susut,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('rekap-lebur.index')->with('success', 'Data rekap lebur berhasil diperbarui.');
    }

    public function destroy(\App\Models\RekapLebur $rekapLebur)
    {
        $rekapLebur->delete();
        return redirect()->route('rekap-lebur.index')->with('success', 'Data rekap lebur berhasil dihapus.');
    }
}
