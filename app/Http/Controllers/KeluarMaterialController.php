<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeluarMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\KeluarMaterial::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('tujuan', 'like', "%$search%")
                    ->orWhere('jenis_material', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('keluar-material.index', compact('records'));
    }

    public function create()
    {
        return view('keluar-material.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tujuan' => 'required|string',
            'jenis_material' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        \App\Models\KeluarMaterial::create([
            'tanggal' => $request->tanggal,
            'tujuan' => $request->tujuan,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('keluar-material.index')->with('success', 'Data material keluar berhasil dicatat.');
    }

    public function edit(\App\Models\KeluarMaterial $keluarMaterial)
    {
        return view('keluar-material.edit', ['record' => $keluarMaterial]);
    }

    public function update(Request $request, \App\Models\KeluarMaterial $keluarMaterial)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tujuan' => 'required|string',
            'jenis_material' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $keluarMaterial->update([
            'tanggal' => $request->tanggal,
            'tujuan' => $request->tujuan,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('keluar-material.index')->with('success', 'Data material keluar berhasil diperbarui.');
    }

    public function destroy(\App\Models\KeluarMaterial $keluarMaterial)
    {
        $keluarMaterial->delete();
        return redirect()->route('keluar-material.index')->with('success', 'Data material keluar berhasil dihapus.');
    }
}
