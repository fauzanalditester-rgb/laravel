<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary-800 leading-tight">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-slate-600">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                    <th class="p-3 border-b">Time</th>
                                    <th class="p-3 border-b">User</th>
                                    <th class="p-3 border-b">Action</th>
                                    <th class="p-3 border-b">Module</th>
                                    <th class="p-3 border-b">Description</th>
                                    <th class="p-3 border-b">IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                                            <tr class="hover:bg-gray-50 transition-colors text-sm">
                                                                <td class="p-3 border-b text-xs text-gray-500">
                                                                    {{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                                                <td class="p-3 border-b font-bold">{{ $log->user ? $log->user->name : 'System' }}
                                                                </td>
                                                                <td class="p-3 border-b">
                                                                    <span
                                                                        class="px-2 py-1 rounded-full text-xs font-bold uppercase 
                                                                        {{ $log->action == 'created' ? 'bg-green-100 text-green-700' :
                                    ($log->action == 'updated' ? 'bg-blue-100 text-blue-700' :
                                        ($log->action == 'deleted' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                                                        {{ $log->action }}
                                                                    </span>
                                                                </td>
                                                                <td class="p-3 border-b text-xs font-bold uppercase tracking-wide">
                                                                    {{ $log->module }}</td>
                                                                <td class="p-3 border-b text-xs text-gray-600 truncate max-w-xs"
                                                                    title="{{ $log->description }}">
                                                                    {{ Str::limit($log->description, 50) }}
                                                                </td>
                                                                <td class="p-3 border-b text-xs text-gray-400 font-mono">{{ $log->ip_address }}</td>
                                                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-400 italic">No activity logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>