<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Material Keluar') }}
            </h2>
            <a href="{{ route('keluar-material.create') }}"
                class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                + Catat Material Keluar
            </a>
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
                                    <th class="p-3 border-b">Tujuan</th>
                                    <th class="p-3 border-b">Material</th>
                                    <th class="p-3 border-b text-right">Jumlah</th>
                                    <th class="p-3 border-b text-right">Harga Satuan</th>
                                    <th class="p-3 border-b text-right">Total</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                                        <td class="p-3 border-b">
                                            {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</td>
                                        <td class="p-3 border-b font-bold">{{ $record->tujuan }}</td>
                                        <td class="p-3 border-b">{{ $record->jenis_material }}</td>
                                        <td class="p-3 border-b text-right">{{ number_format($record->jumlah, 2) }}
                                            {{ $record->satuan }}</td>
                                        <td class="p-3 border-b text-right">Rp
                                            {{ number_format($record->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="p-3 border-b text-right font-bold text-primary-700">Rp
                                            {{ number_format($record->total_harga, 0, ',', '.') }}</td>
                                        <td class="p-3 border-b text-right space-x-2">
                                            <a href="{{ route('keluar-material.edit', $record) }}"
                                                class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                            <form action="{{ route('keluar-material.destroy', $record) }}" method="POST"
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
                                        <td colspan="7" class="p-8 text-center text-gray-400 italic">Belum ada data material
                                            keluar.</td>
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