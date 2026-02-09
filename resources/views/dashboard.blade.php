<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="animate-fade-in">
                <h2 class="font-black text-3xl text-slate-800 leading-tight tracking-tighter">
                    {{ __('Executive Dashboard') }}
                </h2>
                <p class="text-slate-500 text-sm font-medium mt-1 uppercase tracking-widest">Precision Overview &
                    Operations</p>
            </div>
            <div class="flex items-center gap-3 animate-fade-in" style="animation-delay: 0.1s">
                <span
                    class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ now()->format('l, d F Y') }}</span>
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if(isset($anomalyCount) && $anomalyCount > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm animate-fade-in">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold">
                            ⚠️ System Alert: Detected {{ $anomalyCount }} production anomalies (High Shrinkage > 10%). 
                            <a href="{{ route('rekap-lebur.index') }}" class="underline hover:text-red-900">Review immediately.</a>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Welcome Header -->
            <div
                class="relative overflow-hidden red-gradient rounded-[2rem] p-10 text-white shadow-premium animate-fade-in">
                <div class="relative z-10 lg:flex items-center justify-between">
                    <div class="max-w-xl">
                        <h1 class="text-4xl font-black mb-4">Good Day, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-primary-100 text-lg leading-relaxed font-medium">
                            Your ERP System operations are running optimal.
                        </p>
                        <div class="mt-8 flex gap-4">
                            @can('create material')
                                <a href="{{ route('rekap-timbangan.create') }}"
                                    class="btn-premium bg-white text-primary-700 px-6 py-3 rounded-xl font-black text-sm uppercase tracking-widest shadow-xl">
                                    Input Timbangan
                                </a>
                            @endcan
                            @can('create finance')
                                <a href="{{ route('laporan-kas.create') }}"
                                    class="btn-premium bg-gold-500 text-white px-6 py-3 rounded-xl font-black text-sm uppercase tracking-widest shadow-xl">
                                    Catat Kas
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="w-64 h-64 bg-white/10 rounded-full blur-3xl absolute -right-20 -top-20"></div>
                        <div class="text-9xl opacity-20 transform -rotate-12 select-none">📊</div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in"
                style="animation-delay: 0.2s">
                <!-- Penjualan -->
                <div
                    class="glass-card p-6 rounded-3xl border-l-8 border-primary-600 group hover:bg-primary-600 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-2xl group-hover:bg-primary-500 group-hover:scale-110 transition-all duration-500">
                            💹</div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-primary-600 group-hover:text-primary-100">Revenue</span>
                    </div>
                    <div class="text-2xl font-black text-slate-800 group-hover:text-white transition-colors truncate">
                        Rp {{ number_format($total_penjualan, 0, ',', '.') }}
                    </div>
                    <div
                        class="text-xs font-bold uppercase tracking-widest text-slate-400 mt-2 group-hover:text-primary-200">
                        Total Penjualan</div>
                </div>

                <!-- Laporan Kas -->
                <div
                    class="glass-card p-6 rounded-3xl border-l-8 border-gold-500 group hover:bg-gold-500 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-gold-50 flex items-center justify-center text-2xl group-hover:bg-gold-400 group-hover:scale-110 transition-all duration-500">
                            💰</div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-gold-600 group-hover:text-gold-100">Balance</span>
                    </div>
                    <div class="text-2xl font-black text-slate-800 group-hover:text-white transition-colors truncate">
                        Rp {{ number_format($total_kas, 0, ',', '.') }}
                    </div>
                    <div
                        class="text-xs font-bold uppercase tracking-widest text-slate-400 mt-2 group-hover:text-gold-200">
                        Saldo Kas Tersedia</div>
                </div>

                <!-- Hutang -->
                <div
                    class="glass-card p-6 rounded-3xl border-l-8 border-red-500 group hover:bg-red-600 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-2xl group-hover:bg-red-500 group-hover:scale-110 transition-all duration-500">
                            📉</div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-red-600 group-hover:text-red-100">Hutang</span>
                    </div>
                    <div class="text-2xl font-black text-slate-800 group-hover:text-white transition-colors truncate">
                        Rp {{ number_format($total_hutang, 0, ',', '.') }}
                    </div>
                    <div
                        class="text-xs font-bold uppercase tracking-widest text-slate-400 mt-2 group-hover:text-red-200">
                        Belum Lunas</div>
                </div>

                <!-- Piutang -->
                <div
                    class="glass-card p-6 rounded-3xl border-l-8 border-green-500 group hover:bg-green-600 transition-all duration-500">
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-2xl group-hover:bg-green-500 group-hover:scale-110 transition-all duration-500">
                            📈</div>
                        <span
                            class="text-[10px] font-black uppercase tracking-widest text-green-600 group-hover:text-green-100">Piutang</span>
                    </div>
                    <div class="text-2xl font-black text-slate-800 group-hover:text-white transition-colors truncate">
                        Rp {{ number_format($total_piutang, 0, ',', '.') }}
                    </div>
                    <div
                        class="text-xs font-bold uppercase tracking-widest text-slate-400 mt-2 group-hover:text-green-200">
                        Menunggu Pembayaran</div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid lg:grid-cols-3 gap-8">

                <!-- Left Column: Chart & Recent Activity -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Chart Section -->
                    <div class="glass-card rounded-[2rem] p-8 shadow-xl animate-fade-in bg-white"
                        style="animation-delay: 0.25s">
                        <div class="flex items-center justify-between mb-6">
                            <h3
                                class="font-black text-xl text-slate-800 uppercase tracking-tighter flex items-center gap-2">
                                <span class="w-2 h-6 bg-gold-500 rounded-full"></span>
                                Sales Trend
                            </h3>
                        </div>
                        <div class="h-64">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="glass-card rounded-[2rem] overflow-hidden animate-fade-in"
                        style="animation-delay: 0.3s">
                        <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-white">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-6 red-gradient rounded-full"></span>
                                <h3 class="font-black text-xl text-slate-800 uppercase tracking-tighter">Recent Cash
                                    Flow
                                </h3>
                            </div>
                            <a href="{{ route('laporan-kas.index') }}"
                                class="text-xs font-black text-primary-600 hover:text-primary-700 uppercase tracking-widest transition-colors">View
                                All</a>
                        </div>
                        <div class="p-8 space-y-4 bg-white/50">
                            @forelse($recent_kas as $kas)
                                <div
                                    class="flex items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-50 transition-all hover:shadow-md cursor-default">
                                    <div
                                        class="w-12 h-12 rounded-xl {{ $kas->jenis == 'masuk' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center font-bold text-xl">
                                        {{ $kas->jenis == 'masuk' ? '↓' : '↑' }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-black text-sm text-slate-800 uppercase tracking-tight">
                                            {{ $kas->keterangan }}</div>
                                        <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest">
                                            {{ $kas->kategori }} • {{ $kas->created_at->format('H:i A') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div
                                            class="font-black text-sm {{ $kas->jenis == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $kas->jenis == 'masuk' ? '+' : '-' }} Rp
                                            {{ number_format($kas->jumlah, 0, ',', '.') }}
                                        </div>
                                        <span
                                            class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-[9px] font-bold uppercase">Done</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No recent
                                        transactions.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Quick Actions -->
                <div class="space-y-6 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="glass-card rounded-[2rem] p-8 bg-slate-900 border-0 text-white shadow-premium">
                        <h3 class="font-black text-lg mb-6 uppercase tracking-widest flex items-center gap-2">
                            <span class="text-gold-500">⚡</span> Quick Console
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('rekap-timbangan.export.pdf') }}"
                                class="w-full btn-premium bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex items-center gap-4 transition-all text-left group">
                                <div
                                    class="w-10 h-10 rounded-xl gold-gradient flex items-center justify-center text-xl">
                                    📄</div>
                                <div>
                                    <div
                                        class="text-xs font-black uppercase tracking-widest group-hover:text-gold-400 transition-colors">
                                        Export Timbangan</div>
                                    <div class="text-[10px] text-white/50 font-medium">Download PDF Report</div>
                                </div>
                            </a>
                            @can('manage users')
                                <a href="{{ route('admin.users.index') }}"
                                    class="w-full btn-premium bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex items-center gap-4 transition-all text-left group">
                                    <div class="w-10 h-10 rounded-xl red-gradient flex items-center justify-center text-xl">
                                        👥</div>
                                    <div>
                                        <div
                                            class="text-xs font-black uppercase tracking-widest group-hover:text-primary-400 transition-colors">
                                            Manage Users</div>
                                        <div class="text-[10px] text-white/50 font-medium">Admin Panel</div>
                                    </div>
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Material Info Placeholder -->
                    <div class="glass-card rounded-[2rem] p-8 border-t-8 border-gold-500">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">System Status</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <span class="text-xs font-black uppercase text-slate-600">Database</span>
                                <span class="text-xs font-black text-green-600">Connected ●</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                                <span class="text-xs font-black uppercase text-slate-600">Security</span>
                                <span class="text-xs font-black text-green-600">Secure 🔒</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Monthly Sales (Rp)',
                    data: @json($chartValues),
                    borderColor: '#b45309', // Gold-700
                    backgroundColor: 'rgba(245, 158, 11, 0.1)', // Gold-500 alpha
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#b45309',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>