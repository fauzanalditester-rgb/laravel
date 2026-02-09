<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Edit Data Timbangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gold-500">
                <div class="p-8">
                    <form action="{{ route('rekap-timbangan.update', $record) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal" :value="__('Tanggal Timbangan')" />
                                <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal', $record->tanggal)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                            </div>

                            <div>
                                <x-input-label for="nomor_kendaraan" :value="__('Nomor Kendaraan')" />
                                <x-text-input id="nomor_kendaraan" name="nomor_kendaraan" type="text"
                                    class="mt-1 block w-full uppercase" :value="old('nomor_kendaraan', $record->nomor_kendaraan)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nomor_kendaraan')" />
                            </div>

                            <div>
                                <x-input-label for="jenis_material" :value="__('Jenis Material')" />
                                <x-text-input id="jenis_material" name="jenis_material" type="text"
                                    class="mt-1 block w-full" :value="old('jenis_material', $record->jenis_material)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_material')" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="berat_masuk" :value="__('Berat Masuk (Kg)')" />
                                    <x-text-input id="berat_masuk" name="berat_masuk" type="number" step="0.01"
                                        class="mt-1 block w-full" :value="old('berat_masuk', $record->berat_masuk)"
                                        required />
                                    <x-input-error class="mt-2" :messages="$errors->get('berat_masuk')" />
                                </div>
                                <div>
                                    <x-input-label for="berat_keluar" :value="__('Berat Keluar (Kg)')" />
                                    <x-text-input id="berat_keluar" name="berat_keluar" type="number" step="0.01"
                                        class="mt-1 block w-full" :value="old('berat_keluar', $record->berat_keluar)"
                                        required />
                                    <x-input-error class="mt-2" :messages="$errors->get('berat_keluar')" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" />
                            <textarea id="keterangan" name="keterangan"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                rows="3">{{ old('keterangan', $record->keterangan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('rekap-timbangan.index') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <button type="submit"
                                class="bg-primary-700 hover:bg-primary-800 text-white font-extrabold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:scale-105">
                                Perbarui Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>