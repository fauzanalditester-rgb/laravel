<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <div
            class="inline-flex items-center justify-center w-16 h-16 red-gradient rounded-2xl shadow-xl mb-6 transform hover:rotate-6 transition-transform">
            <span class="text-white font-black text-3xl">E</span>
        </div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">Secure Access</h2>
        <p class="text-slate-500 font-bold text-[10px] tracking-[0.2em] uppercase mt-2">ERP System Enterprise Portal</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="email"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-primary-500 focus:border-primary-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="admin@erp.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password Key')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="password"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-primary-500 focus:border-primary-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')"
                class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded h-5 w-5 border-slate-200 text-primary-600 shadow-sm focus:ring-primary-500 transition-all cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-xs font-bold text-slate-500 group-hover:text-slate-800 transition-colors">{{ __('Stay Sessioned') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-black text-slate-400 hover:text-primary-600 uppercase tracking-widest transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Recovery') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit"
                class="w-full btn-premium red-gradient py-4 rounded-xl text-white font-black uppercase tracking-[0.2em] shadow-primary-500/30 hover:shadow-primary-500/50">
                Authorize Login
            </button>
        </div>

        @if (Route::has('register'))
            <p class="mt-8 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                Need clearance? <a href="{{ route('register') }}"
                    class="text-gold-600 hover:text-gold-700 font-black">Request Entry</a>
            </p>
        @endif
    </form>
</x-guest-layout>