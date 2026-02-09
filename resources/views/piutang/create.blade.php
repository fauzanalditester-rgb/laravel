<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Catat Piutang Usaha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gold-500">
                <div class="p-8">
                    <form action="{{ route('piutang.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Transaksi')" />
                                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal', date('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                            </div>

                            <div>
                                <x-input-label for="debitur" :value="__('Nama Debitur')" />
                                <x-text-input id="debitur" name="debitur" type="text" class="mt-1 block w-full"
                                    placeholder="Nama Pelanggan/Karyawan" :value="old('debitur')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('debitur')" />
                            </div>

                            <div>
                                <x-input-label for="jumlah" :value="__('Jumlah (Rp)')" />
                                <x-text-input id="jumlah" name="jumlah" type="number" class="mt-1 block w-full"
                                    placeholder="0" :value="old('jumlah')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                            </div>

                            <div>
                                <x-input-label for="jatuh_tempo" :value="__('Jatuh Tempo')" />
                                <x-text-input id="jatuh_tempo" name="jatuh_tempo" type="date" class="mt-1 block w-full"
                                    :value="old('jatuh_tempo')" />
                                <x-input-error class="mt-2" :messages="$errors->get('jatuh_tempo')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan')" />
                            <textarea id="keterangan" name="keterangan"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                rows="3">{{ old('keterangan') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('piutang.index') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <button type="submit"
                                class="bg-primary-700 hover:bg-primary-800 text-white font-extrabold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:scale-105">
                                Simpan Piutang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>