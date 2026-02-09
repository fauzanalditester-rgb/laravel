<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ERP System | Secure Access</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-slate-900 antialiased selection:bg-gold-500 selection:text-white">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0f172a] relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-gold-900/5 rounded-full blur-[120px]"></div>

        <div
            class="relative z-10 w-full sm:max-w-md px-10 py-12 bg-white/95 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-[2.5rem] border border-white/20">
            {{ $slot }}
        </div>

        <div class="relative z-10 mt-8">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600">&copy; 2026 ERP System
                Management
            </p>
        </div>
    </div>
</body>

</html>