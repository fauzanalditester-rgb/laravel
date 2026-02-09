<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\Piutang::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('debitur', 'like', "%$search%");
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('piutang.index', compact('records'));
    }

    public function create()
    {
        return view('piutang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'debitur' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'required|string',
        ]);

        \App\Models\Piutang::create([
            'tanggal' => $request->tanggal,
            'debitur' => $request->debitur,
            'jumlah' => $request->jumlah,
            'jatuh_tempo' => $request->jatuh_tempo,
            'keterangan' => $request->keterangan,
            'status' => 'belum_lunas',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('piutang.index')->with('success', 'Data piutang berhasil dicatat.');
    }

    public function edit(\App\Models\Piutang $piutang)
    {
        return view('piutang.edit', ['record' => $piutang]);
    }

    public function update(Request $request, \App\Models\Piutang $piutang)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'debitur' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'required|string',
            'status' => 'required|in:belum_lunas,lunas',
        ]);

        $data = $request->only('tanggal', 'debitur', 'jumlah', 'jatuh_tempo', 'keterangan', 'status');

        if ($request->status == 'lunas' && $piutang->status != 'lunas') {
            $data['tanggal_lunas'] = now();
        } elseif ($request->status == 'belum_lunas') {
            $data['tanggal_lunas'] = null;
        }

        $piutang->update($data);

        return redirect()->route('piutang.index')->with('success', 'Data piutang berhasil diperbarui.');
    }

    public function destroy(\App\Models\Piutang $piutang)
    {
        $piutang->delete();
        return redirect()->route('piutang.index')->with('success', 'Data piutang berhasil dihapus.');
    }
}
