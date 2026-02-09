<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Edit Pengajuan Kas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-gold-500">
                <div class="p-8">
                    @if($record->status != 'pending')
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Perhatian</p>
                            <p>Pengajuan ini sudah diproses dan tidak dapat diedit.</p>
                        </div>
                    @else
                        <form action="{{ route('pengajuan-kas.update', $record) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal Pengajuan')" />
                                    <x-text-input id="tanggal" name="tanggal" type="date" class="mt-1 block w-full"
                                        :value="old('tanggal', $record->tanggal)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                                </div>

                                <div>
                                    <x-input-label for="keperluan" :value="__('Keperluan')" />
                                    <x-text-input id="keperluan" name="keperluan" type="text" class="mt-1 block w-full"
                                        :value="old('keperluan', $record->keperluan)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('keperluan')" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="jumlah" :value="__('Jumlah Dana (Rp)')" />
                                    <x-text-input id="jumlah" name="jumlah" type="number"
                                        class="mt-1 block w-full text-lg font-bold" :value="old('jumlah', $record->jumlah)"
                                        required />
                                    <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan Tambahan')" />
                                <textarea id="keterangan" name="keterangan"
                                    class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                    rows="3">{{ old('keterangan', $record->keterangan) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                            </div>

                            <div class="flex items-center justify-end mt-6 gap-4">
                                <a href="{{ route('pengajuan-kas.index') }}"
                                    class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                                <button type="submit"
                                    class="bg-primary-700 hover:bg-primary-800 text-white font-extrabold py-3 px-8 rounded-xl shadow-lg transition-all transform hover:scale-105">
                                    Perbarui Pengajuan
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>