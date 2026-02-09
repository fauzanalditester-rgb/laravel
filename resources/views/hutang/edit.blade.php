<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Edit Hutang Usaha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gold-500">
                <div class="p-8">
                    <form action="{{ route('hutang.update', $record) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Transaksi')" />
                                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal', $record->tanggal)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                            </div>

                            <div>
                                <x-input-label for="kreditur" :value="__('Nama Kreditur')" />
                                <x-text-input id="kreditur" name="kreditur" type="text" class="mt-1 block w-full"
                                    :value="old('kreditur', $record->kreditur)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('kreditur')" />
                            </div>

                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah (Rp)')" />
                                <x-text-input id="jumlah" name="jumlah" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('jumlah', $record->jumlah)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                            </div>

                            <div>
                                <x-input-label for="jatuh_tempo" :value="__('Jatuh Tempo')" />
                                <x-text-input id="jatuh_tempo" name="jatuh_tempo" type="date" class="mt-1 block w-full"
                                    :value="old('jatuh_tempo', $record->jatuh_tempo)" />
                                <x-input-error class="mt-2" :messages="$errors->get('jatuh_tempo')" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status Pembayaran')" />
                                <select id="status" name="status"
                                    class="mt-1 block w-full border-gray-300 focus:border-gold-500 focus:ring-gold-500 rounded-md shadow-sm">
                                    <option value="belum_lunas" {{ $record->status == 'belum_lunas' ? 'selected' : '' }}>
                                        Belum Lunas</option>
                                    <option value="lunas" {{ $record->status == 'lunas' ? 'selected' : '' }}>Lunas
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <textarea id="keterangan" name="keterangan"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                rows="3">{{ old('keterangan', $record->keterangan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('hutang.index') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <button type="submit"
                                class="bg-primary-700 hover:bg-primary-800 text-white font-extrabold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:scale-105">
                                Perbarui Hutang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>