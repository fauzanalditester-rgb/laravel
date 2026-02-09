<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP System | Management System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased selection:bg-gold-500 selection:text-white">
    <div class="relative min-h-screen bg-[#0f172a] overflow-hidden">
        <!-- Abstract Background Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-gold-900/10 rounded-full blur-[120px]"></div>

        <!-- Navigation -->
        <nav class="relative z-10 flex items-center justify-between px-8 py-6 max-w-7xl mx-auto">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 red-gradient rounded-xl flex items-center justify-center shadow-lg transform rotate-12">
                    <span class="text-white font-black text-2xl -rotate-12">E</span>
                </div>
                <span class="text-2xl font-bold tracking-tighter text-white">ERP <span
                        class="text-gold-500">SYSTEM</span></span>
            </div>

            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white font-medium hover:text-gold-400 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white font-medium hover:text-gold-400 transition-colors border-b-2 border-transparent hover:border-gold-500 pb-1">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn-premium gold-gradient px-6 py-2.5 rounded-full text-white font-bold text-sm">Get
                                Started</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 max-w-7xl mx-auto px-8 pt-20 pb-32 grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/10 border border-primary-500/20 mb-6">
                    <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-primary-400 uppercase tracking-widest">Enterprise
                        Solution</span>
                </div>
                <h1 class="text-6xl lg:text-7xl font-extrabold text-white leading-tight tracking-tighter mb-6">
                    Manage Your <span class="text-transparent bg-clip-text gold-gradient">Business</span> with
                    Precision.
                </h1>
                <p class="text-lg text-slate-400 max-w-lg mb-10 leading-relaxed">
                    Integrated management system for your business. Track materials, monitor finances, and optimize your
                    operations with our state-of-the-art industrial platform.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}"
                        class="btn-premium red-gradient px-8 py-4 rounded-2xl text-white font-extrabold text-lg flex items-center gap-3">
                        Launch Portal
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <div class="flex -space-x-3">
                        <div
                            class="w-10 h-10 rounded-full border-2 border-[#0f172a] bg-slate-800 flex items-center justify-center text-[10px] text-white font-bold">
                            JD</div>
                        <div
                            class="w-10 h-10 rounded-full border-2 border-[#0f172a] bg-primary-700 flex items-center justify-center text-[10px] text-white font-bold">
                            AS</div>
                        <div
                            class="w-10 h-10 rounded-full border-2 border-[#0f172a] bg-gold-600 flex items-center justify-center text-[10px] text-white font-bold">
                            RK</div>
                        <div class="w-12 h-10 flex items-center justify-center pl-4 text-xs text-slate-400">Trusted by
                            team</div>
                    </div>
                </div>
            </div>

            <div class="relative animate-fade-in" style="animation-delay: 0.2s">
                <div class="glass-card rounded-[40px] p-2 overflow-hidden bg-white/5 border-white/10">
                    <div class="bg-slate-900 rounded-[35px] overflow-hidden shadow-2xl">
                        <!-- Mockup UI -->
                        <div class="p-6 border-b border-white/5 flex items-center justify-between">
                            <div class="flex gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                            </div>
                            <div class="text-[10px] font-bold text-slate-500 tracking-[0.2em] uppercase">erp_system_os
                                v2.0</div>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="h-32 rounded-2xl bg-white/5 border border-white/10 p-4">
                                    <div class="w-8 h-8 rounded-lg gold-gradient mb-3"></div>
                                    <div class="h-2 w-16 bg-white/10 rounded-full mb-2"></div>
                                    <div class="h-4 w-24 bg-white/20 rounded-full"></div>
                                </div>
                                <div class="h-32 rounded-2xl bg-white/5 border border-white/10 p-4">
                                    <div class="w-8 h-8 rounded-lg red-gradient mb-3"></div>
                                    <div class="h-2 w-16 bg-white/10 rounded-full mb-2"></div>
                                    <div class="h-4 w-24 bg-white/20 rounded-full"></div>
                                </div>
                            </div>
                            <div
                                class="h-40 rounded-2xl bg-white/5 border border-white/10 p-4 flex flex-col justify-end">
                                <div class="flex items-end gap-1 h-full mb-4">
                                    <div class="flex-1 bg-gold-500/20 h-[30%] rounded-t-lg"></div>
                                    <div class="flex-1 bg-gold-400 h-[60%] rounded-t-lg"></div>
                                    <div class="flex-1 bg-gold-600 h-[45%] rounded-t-lg"></div>
                                    <div class="flex-1 bg-primary-500 h-[80%] rounded-t-lg"></div>
                                    <div class="flex-1 bg-primary-700 h-[65%] rounded-t-lg"></div>
                                    <div class="flex-1 bg-primary-600 h-[95%] rounded-t-lg"></div>
                                </div>
                                <div class="h-3 w-40 bg-white/20 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badges -->
                <div class="absolute -top-6 -right-6 glass-card p-4 rounded-2xl flex items-center gap-3 animate-bounce shadow-2xl"
                    style="animation-duration: 4s">
                    <div class="w-10 h-10 rounded-xl gold-gradient flex items-center justify-center text-white">💰</div>
                    <div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Revenue</div>
                        <div class="text-sm font-black text-slate-900">+42.5%</div>
                    </div>
                </div>

                <div class="absolute -bottom-10 -left-10 glass-card p-4 rounded-2xl flex items-center gap-3 animate-bounce shadow-2xl"
                    style="animation-duration: 5s; animation-delay: 1s">
                    <div class="w-10 h-10 rounded-xl red-gradient flex items-center justify-center text-white">📦</div>
                    <div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Stock</div>
                        <div class="text-sm font-black text-slate-900">Optimal</div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer
            class="relative z-10 max-w-7xl mx-auto px-8 py-12 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6 text-slate-500 text-sm">
            <p>&copy; 2026 ERP System Management. All rights reserved.</p>
            <div class="flex gap-8">
                <a href="#" class="hover:text-gold-500 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gold-500 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-gold-500 transition-colors">Support</a>
            </div>
        </footer>
    </div>
</body>

</html>