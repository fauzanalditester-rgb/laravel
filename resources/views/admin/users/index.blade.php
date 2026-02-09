<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-primary-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.users.create') }}"
                class="btn-premium bg-gold-500 hover:bg-gold-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                + Create User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-primary-600">
                <div class="p-6">
                    <!-- Filters -->
                    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-6 flex gap-4">
                        <input type="text" name="search" placeholder="Cari User..." value="{{ request('search') }}"
                            class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 w-full md:w-1/3">
                        <button type="submit"
                            class="bg-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:bg-primary-800 transition-colors">Search</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                    <th class="p-3 border-b">Nama</th>
                                    <th class="p-3 border-b">Email</th>
                                    <th class="p-3 border-b">Role</th>
                                    <th class="p-3 border-b">Status</th>
                                    <th class="p-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors text-sm">
                                        <td class="p-3 border-b font-bold">{{ $user->name }}</td>
                                        <td class="p-3 border-b text-gray-500">{{ $user->email }}</td>
                                        <td class="p-3 border-b">
                                            @foreach($user->roles as $role)
                                                                            <span
                                                                                class="px-2 py-1 rounded-full text-xs font-bold uppercase 
                                                                                    {{ $role->name == 'Super Admin' ? 'bg-primary-100 text-primary-700' :
                                                ($role->name == 'Admin' ? 'bg-blue-100 text-blue-700' : 'bg-gold-100 text-gold-700') }}">
                                                                                {{ $role->name }}
                                                                            </span>
                                            @endforeach
                                        </td>
                                        <td class="p-3 border-b">
                                            <span
                                                class="text-xs font-bold {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b text-right space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-gold-600 hover:text-gold-700 font-bold">Edit</a>
                                            @if(auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-primary-600 hover:text-primary-700 font-bold">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400 italic">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>