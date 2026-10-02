<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SRPE') }} &mdash; SMKN 3 Payakumbuh</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col items-center justify-center p-4">
            <!-- Logo / Brand -->
            <a href="/" class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-bold text-slate-900 leading-tight">SRPE</p>
                    <p class="text-xs text-slate-500 leading-tight">SMK Negeri 3 Payakumbuh</p>
                </div>
            </a>

            <!-- Card -->
            <div class="w-full max-w-sm bg-white shadow-sm border border-slate-200 rounded-xl p-6">
                {{ $slot }}
            </div>

            <!-- Footer note -->
            <p class="mt-6 text-xs text-slate-400 text-center">
                &copy; {{ date('Y') }} SRPE SMKN 3 Payakumbuh
            </p>
        </div>
    </body>
</html>
