<x-guest-layout>
    <div class="mb-8 text-center animate-fade-in">
        <div
            class="inline-flex items-center justify-center w-16 h-16 gold-gradient rounded-2xl shadow-xl mb-6 transform hover:-rotate-6 transition-transform">
            <span class="text-white font-black text-3xl">E</span>
        </div>
        <h2 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">Join Command</h2>
        <p class="text-slate-500 font-bold text-[10px] tracking-[0.2em] uppercase mt-2">Create your personnel profile
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="name"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-gold-500 focus:border-gold-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="email"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-gold-500 focus:border-gold-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="john@erp.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Secure Password')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="password"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-gold-500 focus:border-gold-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')"
                class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Re-enter Password')"
                class="font-black text-[10px] uppercase tracking-widest text-slate-400 mb-1" />
            <x-text-input id="password_confirmation"
                class="block w-full bg-slate-50 border-slate-200 focus:bg-white focus:ring-gold-500 focus:border-gold-500 rounded-xl transition-all h-12 px-4 font-bold"
                type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')"
                class="mt-2 text-xs font-bold uppercase tracking-widest" />
        </div>

        <div class="mt-8">
            <button type="submit"
                class="w-full btn-premium gold-gradient py-4 rounded-xl text-white font-black uppercase tracking-[0.2em] shadow-gold-500/30">
                Register Account
            </button>
        </div>

        <p class="mt-8 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
            Already authorized? <a href="{{ route('login') }}"
                class="text-primary-600 hover:text-primary-700 font-black">Identify Yourself</a>
        </p>
    </form>
</x-guest-layout>