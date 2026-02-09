<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Penjualan Material') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('penjualan.export.pdf') }}"
                    class="btn-premium bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors text-xs uppercase tracking-wider">
                    Export PDF
                </a>
                <a href="{{ route('penjualan.export.excel') }}"
                    class="btn-premium bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors text-xs uppercase tracking-wider">
                    Export Excel
                </a>
                <a href="{{ route('penjualan.create') }}"
                    class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                    + Catat Penjualan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-primary-600">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                    <th class="p-3 border-b">Tanggal</th>
                                    <th class="p-3 border-b">Invoice</th>
                                    <th class="p-3 border-b">Customer</th>
                                    <th class="p-3 border-b">Material</th>
                                    <th class="p-3 border-b text-right">Jumlah</th>
                                    <th class="p-3 border-b text-right">Total Harga</th>
                                    <th class="p-3 border-b text-center">Status</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                                                <td class="p-3 border-b">
                                                                    {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</td>
                                                                <td class="p-3 border-b font-mono text-xs">{{ $record->nomor_invoice }}</td>
                                                                <td class="p-3 border-b font-bold">{{ $record->customer }}</td>
                                                                <td class="p-3 border-b">{{ $record->jenis_material }}</td>
                                                                <td class="p-3 border-b text-right">{{ number_format($record->jumlah, 2) }}
                                                                    {{ $record->satuan }}</td>
                                                                <td class="p-3 border-b text-right font-bold text-primary-700">Rp
                                                                    {{ number_format($record->total_harga, 0, ',', '.') }}</td>
                                                                <td class="p-3 border-b text-center">
                                                                    <span
                                                                        class="px-2 py-1 rounded-full text-xs font-bold uppercase 
                                                                        {{ $record->status_bayar == 'paid' ? 'bg-green-100 text-green-700' :
                                    ($record->status_bayar == 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                                        {{ $record->status_bayar }}
                                                                    </span>
                                                                </td>
                                                                <td class="p-3 border-b text-right space-x-2">
                                                                    <a href="{{ route('penjualan.edit', $record) }}"
                                                                        class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                                                    <form action="{{ route('penjualan.destroy', $record) }}" method="POST"
                                                                        class="inline" onsubmit="return confirm('Hapus data ini?')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="text-primary-600 hover:text-primary-700 font-bold">Hapus</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="p-8 text-center text-gray-400 italic">Belum ada data
                                            penjualan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>