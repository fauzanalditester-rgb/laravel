<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Laporan Kas') }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('laporan-kas.export.pdf') }}"
                    class="btn-premium bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors text-xs uppercase tracking-wider">
                    Export PDF
                </a>
                <a href="{{ route('laporan-kas.create') }}"
                    class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                    + Catat Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="glass-card p-6 rounded-2xl border-l-4 border-green-500">
                    <div class="text-xs font-bold text-gray-500 uppercase">Total Pemasukan</div>
                    <div class="text-2xl font-black text-green-600">Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl border-l-4 border-red-500">
                    <div class="text-xs font-bold text-gray-500 uppercase">Total Pengeluaran</div>
                    <div class="text-2xl font-black text-red-600">Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl border-l-4 border-gold-500 bg-gold-50">
                    <div class="text-xs font-bold text-gray-500 uppercase">Saldo Akhir</div>
                    <div class="text-3xl font-black text-gold-700">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="glass-card bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-primary-600">
                <div class="p-6">
                    <!-- Filters -->
                    <form action="{{ route('laporan-kas.index') }}" method="GET"
                        class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="search" placeholder="Cari Keterangan..."
                            value="{{ request('search') }}"
                            class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                        <select name="jenis"
                            class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Semua Jenis</option>
                            <option value="in" {{ request('jenis') == 'in' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="out" {{ request('jenis') == 'out' ? 'selected' : '' }}>Pengeluaran
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-primary-800 transition-colors w-full md:w-auto">Filter
                            Data</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                    <th class="p-3 border-b">Tanggal</th>
                                    <th class="p-3 border-b">Keterangan</th>
                                    <th class="p-3 border-b">Kategori</th>
                                    <th class="p-3 border-b text-right">Masuk (Debet)</th>
                                    <th class="p-3 border-b text-right">Keluar (Kredit)</th>
                                    <th class="p-3 border-b text-right">Saldo</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                                        <td class="p-3 border-b">
                                            {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}
                                        </td>
                                        <td class="p-3 border-b font-medium">{{ $record->keterangan }}</td>
                                        <td class="p-3 border-b text-xs uppercase text-gray-500">{{ $record->kategori }}
                                        </td>
                                        <td class="p-3 border-b text-right font-bold text-green-600">
                                            {{ $record->jenis == 'in' ? number_format($record->jumlah, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="p-3 border-b text-right font-bold text-red-600">
                                            {{ $record->jenis == 'out' ? number_format($record->jumlah, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="p-3 border-b text-right font-bold text-gray-800">Rp
                                            {{ number_format($record->saldo, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 border-b text-right space-x-2">
                                            <form action="{{ route('laporan-kas.destroy', $record) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-primary-600 hover:text-primary-700 font-bold text-xs">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="p-8 text-center text-gray-400 italic">Belum ada data
                                            transaksi kas.</td>
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