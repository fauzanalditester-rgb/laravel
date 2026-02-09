<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('Pengajuan Kas') }}
            </h2>
            <a href="{{ route('pengajuan-kas.create') }}"
                class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                + Buat Pengajuan
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
                                    <th class="p-3 border-b">Keperluan</th>
                                    <th class="p-3 border-b text-right">Jumlah</th>
                                    <th class="p-3 border-b">Status</th>
                                    <th class="p-3 border-b">Approved By</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records as $record)
                                                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                                                <td class="p-3 border-b">
                                                                    {{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</td>
                                                                <td class="p-3 border-b font-bold">{{ $record->keperluan }}</td>
                                                                <td class="p-3 border-b text-right font-bold text-primary-700">Rp
                                                                    {{ number_format($record->jumlah, 0, ',', '.') }}</td>
                                                                <td class="p-3 border-b">
                                                                    <span
                                                                        class="px-2 py-1 rounded-full text-xs font-bold uppercase 
                                                                        {{ $record->status == 'approved' ? 'bg-green-100 text-green-700' :
                                    ($record->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                                        {{ $record->status }}
                                                                    </span>
                                                                </td>
                                                                <td class="p-3 border-b text-gray-500 text-xs">
                                                                    {{ $record->approver ? $record->approver->name : '-' }}</td>
                                                                <td class="p-3 border-b text-right space-x-2">
                                                                    @if($record->status == 'pending')
                                                                        <a href="{{ route('pengajuan-kas.edit', $record) }}"
                                                                            class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                                                        <form action="{{ route('pengajuan-kas.destroy', $record) }}" method="POST"
                                                                            class="inline" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="text-primary-600 hover:text-primary-700 font-bold">Hapus</button>
                                                                        </form>
                                                                        @role('Super Admin')
                                                                        <!-- Approval Buttons for Super Admin -->
                                                                        <div class="flex gap-2 justify-end mt-2">
                                                                            <form action="{{ route('pengajuan-kas.approve', $record) }}" method="POST">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="text-green-600 hover:text-green-800 font-bold text-xs">Approve</button>
                                                                            </form>
                                                                            <form action="{{ route('pengajuan-kas.reject', $record) }}" method="POST">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="text-red-600 hover:text-red-800 font-bold text-xs">Reject</button>
                                                                            </form>
                                                                        </div>
                                                                        @endrole
                                                                    @else
                                                                        <span class="text-gray-400 italic text-xs">Locked</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-400 italic">Belum ada pengajuan
                                            kas.</td>
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