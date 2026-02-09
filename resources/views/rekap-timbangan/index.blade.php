<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Rekap Timbangan') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('rekap-timbangan.export.pdf') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors text-sm flex items-center">
                    PDF
                </a>
                <a href="{{ route('rekap-timbangan.export.excel') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors text-sm flex items-center">
                    Excel
                </a>
                <a href="{{ route('rekap-timbangan.create') }}"
                    class="bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors flex items-center">
                    + Input
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-primary-600">
                <div class="p-6">
                    <!-- Filters -->
                    <form action="{{ route('rekap-timbangan.index') }}" method="GET"
                        class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="search" placeholder="Cari No. Kendaraan / Material..."
                            value="{{ request('search') }}"
                            class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        <button type="submit"
                            class="bg-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-primary-800 transition-colors w-full md:w-auto">Filter
                            Data</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                    <th class="p-3 border-b">Tanggal</th>
                                    <th class="p-3 border-b">No. Kendaraan</th>
                                    <th class="p-3 border-b">Jenis Material</th>
                                    <th class="p-3 border-b text-right">Berat Masuk (Kg)</th>
                                    <th class="p-3 border-b text-right">Berat Keluar (Kg)</th>
                                    <th class="p-3 border-b text-right">Berat Bersih (Kg)</th>
                                    <th class="p-3 border-b">Petugas</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                                        <td class="p-3 border-b font-medium">
                                            {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}
                                        </td>
                                        <td class="p-3 border-b font-bold text-primary-700 uppercase">
                                            {{ $record->nomor_kendaraan }}
                                        </td>
                                        <td class="p-3 border-b">{{ $record->jenis_material }}</td>
                                        <td class="p-3 border-b text-right">
                                            {{ number_format($record->berat_masuk, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 border-b text-right">
                                            {{ number_format($record->berat_keluar, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 border-b text-right font-bold text-gray-900">
                                            {{ number_format($record->berat_bersih, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 border-b text-xs text-gray-500">{{ $record->creator->name }}</td>
                                        <td class="p-3 border-b text-right space-x-2">
                                            <a href="{{ route('rekap-timbangan.edit', $record) }}"
                                                class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                            <form action="{{ route('rekap-timbangan.destroy', $record) }}" method="POST"
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
                                            timbangan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>