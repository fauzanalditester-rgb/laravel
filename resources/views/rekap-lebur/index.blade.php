<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Rekap Lebur') }}
            </h2>
            <a href="{{ route('rekap-lebur.create') }}"
                class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                + Catat Lebur
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
                                    <th class="p-3 border-b">Material</th>
                                    <th class="p-3 border-b text-right">Berat Awal</th>
                                    <th class="p-3 border-b text-right">Berat Hasil</th>
                                    <th class="p-3 border-b text-right">Susut</th>
                                    <th class="p-3 border-b text-right">% Susut</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                                        <td class="p-3 border-b">
                                            {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</td>
                                        <td class="p-3 border-b font-bold">{{ $record->jenis_material }}</td>
                                        <td class="p-3 border-b text-right">{{ number_format($record->berat_awal, 2) }}</td>
                                        <td class="p-3 border-b text-right">{{ number_format($record->berat_hasil, 2) }}
                                        </td>
                                        <td class="p-3 border-b text-right text-red-600 font-bold">
                                            {{ number_format($record->susut, 2) }}</td>
                                        <td class="p-3 border-b text-right">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-bold {{ $record->persentase_susut > 5 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ number_format($record->persentase_susut, 2) }}%
                                            </span>
                                        </td>
                                        <td class="p-3 border-b text-right space-x-2">
                                            <a href="{{ route('rekap-lebur.edit', $record) }}"
                                                class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                            <form action="{{ route('rekap-lebur.destroy', $record) }}" method="POST"
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
                                        <td colspan="7" class="p-8 text-center text-gray-400 italic">Belum ada data rekap
                                            lebur.</td>
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