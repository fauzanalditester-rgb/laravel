<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\Hutang::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('kreditur', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('hutang.index', compact('records'));
    }

    public function create()
    {
        return view('hutang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kreditur' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'required|string',
        ]);

        \App\Models\Hutang::create([
            'tanggal' => $request->tanggal,
            'kreditur' => $request->kreditur,
            'jumlah' => $request->jumlah,
            'jatuh_tempo' => $request->jatuh_tempo,
            'keterangan' => $request->keterangan,
            'status' => 'belum_lunas',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil dicatat.');
    }

    public function edit(\App\Models\Hutang $hutang)
    {
        return view('hutang.edit', ['record' => $hutang]);
    }

    public function update(Request $request, \App\Models\Hutang $hutang)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kreditur' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'required|string',
            'status' => 'required|in:belum_lunas,lunas',
        ]);

        $data = $request->only('tanggal', 'kreditur', 'jumlah', 'jatuh_tempo', 'keterangan', 'status');

        if ($request->status == 'lunas' && $hutang->status != 'lunas') {
            $data['tanggal_lunas'] = now();
        } elseif ($request->status == 'belum_lunas') {
            $data['tanggal_lunas'] = null;
        }

        $hutang->update($data);

        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil diperbarui.');
    }

    public function destroy(\App\Models\Hutang $hutang)
    {
        $hutang->delete();
        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil dihapus.');
    }
}
