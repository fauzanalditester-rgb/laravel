<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div
                            class="w-10 h-10 red-gradient rounded-xl flex items-center justify-center shadow-lg transition-transform group-hover:rotate-6">
                            <span class="text-white font-black text-xl">E</span>
                        </div>
                        <span class="text-xl font-bold tracking-tighter text-slate-800">ERP <span
                                class="text-gold-500 uppercase">System</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="px-4 py-2 text-xs font-bold uppercase tracking-widest transition-all rounded-xl {{ request()->routeIs('dashboard') ? 'text-primary-700 bg-primary-50' : 'text-slate-500 hover:bg-slate-50' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Material Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-xs leading-4 font-bold rounded-xl text-slate-500 bg-white hover:bg-slate-50 focus:outline-none transition group uppercase tracking-widest">
                                    <div class="group-hover:text-primary-700">Material</div>
                                    <div class="ms-1 group-hover:text-primary-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Inventory Management</div>
                                <x-dropdown-link :href="route('rekap-timbangan.index')" class="font-bold text-sm">Rekap
                                    Timbangan</x-dropdown-link>
                                <x-dropdown-link :href="route('raw-material.index')" class="font-bold text-sm">Raw
                                    Material (Masuk)</x-dropdown-link>
                                <x-dropdown-link :href="route('keluar-material.index')" class="font-bold text-sm">Keluar
                                    Material</x-dropdown-link>
                                <x-dropdown-link :href="route('rekap-lebur.index')"
                                    class="font-bold text-sm hover:bg-slate-50">Rekap Lebur</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Keuangan Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-xs leading-4 font-bold rounded-xl text-slate-500 bg-white hover:bg-slate-50 focus:outline-none transition group uppercase tracking-widest">
                                    <div class="group-hover:text-primary-700">Keuangan</div>
                                    <div class="ms-1 group-hover:text-primary-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    Financial Reports</div>
                                <x-dropdown-link :href="route('penjualan.index')" class="font-bold text-sm">Penjualan
                                    Material</x-dropdown-link>
                                <x-dropdown-link :href="route('laporan-kas.index')"
                                    class="font-bold text-sm text-primary-700 bg-primary-50">Laporan
                                    Kas</x-dropdown-link>
                                <x-dropdown-link :href="route('pengajuan-kas.index')"
                                    class="font-bold text-sm">Pengajuan Kas</x-dropdown-link>
                                <div class="border-t border-slate-100 my-1"></div>
                                <x-dropdown-link :href="route('hutang.index')"
                                    class="font-bold text-sm text-red-600">Hutang Usaha</x-dropdown-link>
                                <x-dropdown-link :href="route('piutang.index')"
                                    class="font-bold text-sm text-green-600">Piutang Usaha</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-slate-50 border border-slate-200 rounded-2xl text-xs leading-4 font-black text-slate-700 hover:bg-gold-500 hover:text-white hover:border-gold-600 transition-all focus:outline-none uppercase tracking-widest shadow-sm">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-2 h-2 rounded-full {{ auth()->user()->hasRole('Super Admin') ? 'bg-primary-500 shadow-primary-500/50' : 'bg-gold-500' }} shadow-lg">
                                </div>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Account &
                                Security</div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold text-sm">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        @role('Super Admin')
                        <x-dropdown-link :href="route('admin.users.index')"
                            class="font-bold text-sm text-primary-700 border-t border-slate-100 bg-primary-50/50">
                            {{ __('User Management') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.activity-logs.index')"
                            class="font-bold text-sm text-primary-700 bg-primary-50/50">
                            {{ __('Audit Logs') }}
                        </x-dropdown-link>
                        @endrole

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600 font-black border-t border-slate-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100 animate-fade-in">
        <div class="pt-2 pb-3 space-y-1 bg-white">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="font-black uppercase tracking-widest text-xs">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rekap-timbangan.index')" class="font-bold text-sm">Rekap
                Timbangan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('raw-material.index')" class="font-bold text-sm">Raw
                Material</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('laporan-kas.index')" class="font-bold text-sm text-primary-700">Laporan
                Kas</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-100 bg-slate-50">
            <div class="px-4 flex items-center gap-3">
                <div
                    class="w-10 h-10 red-gradient rounded-full flex items-center justify-center text-white font-black text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-black text-xs text-slate-800 uppercase tracking-widest">{{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-[10px] text-slate-500 uppercase tracking-wider">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-bold text-sm">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-600 font-black">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>