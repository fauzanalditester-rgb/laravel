<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\RawMaterial::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('supplier', 'like', "%$search%")
                    ->orWhere('jenis_material', 'like', "%$search%");
            })
            ->latest('tanggal_terima')
            ->paginate(15);

        return view('raw-material.index', compact('records'));
    }

    public function create()
    {
        return view('raw-material.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'supplier' => 'required|string|max:100',
            'jenis_material' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        \App\Models\RawMaterial::create([
            'tanggal_terima' => $request->tanggal_terima,
            'supplier' => $request->supplier,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('raw-material.index')->with('success', 'Data raw material berhasil masuk.');
    }

    public function edit(\App\Models\RawMaterial $rawMaterial)
    {
        return view('raw-material.edit', ['record' => $rawMaterial]);
    }

    public function update(Request $request, \App\Models\RawMaterial $rawMaterial)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'supplier' => 'required|string|max:100',
            'jenis_material' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $rawMaterial->update([
            'tanggal_terima' => $request->tanggal_terima,
            'supplier' => $request->supplier,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('raw-material.index')->with('success', 'Data raw material berhasil diperbarui.');
    }

    public function destroy(\App\Models\RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();
        return redirect()->route('raw-material.index')->with('success', 'Data raw material berhasil dihapus.');
    }
}
