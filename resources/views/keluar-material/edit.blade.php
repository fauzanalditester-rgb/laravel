<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Edit Material Keluar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gold-500">
                <div class="p-8">
                    <form action="{{ route('keluar-material.update', $record) }}" method="POST" class="space-y-6">
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
                                <x-input-label for="tujuan" :value="__('Tujuan / Lokasi')" />
                                <x-text-input id="tujuan" name="tujuan" type="text" class="mt-1 block w-full"
                                    :value="old('tujuan', $record->tujuan)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tujuan')" />
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
                                    <x-input-label for="jumlah" :value="__('Jumlah')" />
                                    <x-text-input id="jumlah" name="jumlah" type="number" step="0.01"
                                        class="mt-1 block w-full" :value="old('jumlah', $record->jumlah)" required />
                                </div>
                                <div>
                                    <x-input-label for="satuan" :value="__('Satuan')" />
                                    <x-text-input id="satuan" name="satuan" type="text" class="mt-1 block w-full"
                                        :value="old('satuan', $record->satuan)" required />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="harga_satuan" :value="__('Harga Satuan (Rp)')" />
                                <x-text-input id="harga_satuan" name="harga_satuan" type="number"
                                    class="mt-1 block w-full" :value="old('harga_satuan', $record->harga_satuan)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga_satuan')" />
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
                            <a href="{{ route('keluar-material.index') }}"
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