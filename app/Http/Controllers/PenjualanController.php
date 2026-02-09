<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\Penjualan::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('nomor_invoice', 'like', "%$search%")
                    ->orWhere('customer', 'like', "%$search%")
                    ->orWhere('jenis_material', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('penjualan.index', compact('records'));
    }

    public function create()
    {
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'customer' => 'required|string',
            'jenis_material' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:paid,unpaid,partial',
            'keterangan' => 'nullable|string',
        ]);

        $nomor_invoice = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));

        \App\Models\Penjualan::create([
            'nomor_invoice' => $nomor_invoice,
            'tanggal' => $request->tanggal,
            'customer' => $request->customer,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'status_bayar' => $request->status_bayar,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dicatat.');
    }

    public function edit(\App\Models\Penjualan $penjualan)
    {
        return view('penjualan.edit', ['record' => $penjualan]);
    }

    public function update(Request $request, \App\Models\Penjualan $penjualan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'customer' => 'required|string',
            'jenis_material' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:paid,unpaid,partial',
            'keterangan' => 'nullable|string',
        ]);

        $penjualan->update([
            'tanggal' => $request->tanggal,
            'customer' => $request->customer,
            'jenis_material' => $request->jenis_material,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->jumlah * $request->harga_satuan,
            'status_bayar' => $request->status_bayar,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy(\App\Models\Penjualan $penjualan)
    {
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
    }
}
