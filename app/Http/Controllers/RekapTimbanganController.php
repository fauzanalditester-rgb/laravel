<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapTimbanganExport;

class RekapTimbanganController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new RekapTimbanganExport, 'rekap_timbangan.xlsx');
    }

    public function exportPdf()
    {
        $records = \App\Models\RekapTimbangan::with('creator')->latest('tanggal')->get();
        $pdf = Pdf::loadView('rekap-timbangan.pdf', compact('records'));
        return $pdf->download('rekap_timbangan.pdf');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = \App\Models\RekapTimbangan::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('nomor_kendaraan', 'like', "%$search%")
                    ->orWhere('jenis_material', 'like', "%$search%");
            })
            ->when($request->tanggal, function ($query, $tanggal) {
                $query->whereDate('tanggal', $tanggal);
            })
            ->latest('tanggal')
            ->paginate(15);

        return view('rekap-timbangan.index', compact('records'));
    }

    public function create()
    {
        return view('rekap-timbangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_kendaraan' => 'required|string|max:50',
            'jenis_material' => 'required|string|max:100',
            'berat_masuk' => 'required|numeric|min:0',
            'berat_keluar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $berat_bersih = abs($request->berat_masuk - $request->berat_keluar);

        \App\Models\RekapTimbangan::create([
            'tanggal' => $request->tanggal,
            'nomor_kendaraan' => $request->nomor_kendaraan,
            'jenis_material' => $request->jenis_material,
            'berat_masuk' => $request->berat_masuk,
            'berat_keluar' => $request->berat_keluar,
            'berat_bersih' => $berat_bersih,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('rekap-timbangan.index')->with('success', 'Data timbangan berhasil disimpan.');
    }

    public function edit(\App\Models\RekapTimbangan $rekapTimbangan)
    {
        return view('rekap-timbangan.edit', ['record' => $rekapTimbangan]);
    }

    public function update(Request $request, \App\Models\RekapTimbangan $rekapTimbangan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_kendaraan' => 'required|string|max:50',
            'jenis_material' => 'required|string|max:100',
            'berat_masuk' => 'required|numeric|min:0',
            'berat_keluar' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $berat_bersih = abs($request->berat_masuk - $request->berat_keluar);

        $rekapTimbangan->update([
            'tanggal' => $request->tanggal,
            'nomor_kendaraan' => $request->nomor_kendaraan,
            'jenis_material' => $request->jenis_material,
            'berat_masuk' => $request->berat_masuk,
            'berat_keluar' => $request->berat_keluar,
            'berat_bersih' => $berat_bersih,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('rekap-timbangan.index')->with('success', 'Data timbangan berhasil diperbarui.');
    }

    public function destroy(\App\Models\RekapTimbangan $rekapTimbangan)
    {
        $rekapTimbangan->delete();
        return redirect()->route('rekap-timbangan.index')->with('success', 'Data timbangan berhasil dihapus.');
    }
}
