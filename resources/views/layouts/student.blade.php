<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Siswa') — SRPE SMKN 3 Payakumbuh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

<!-- Top Navigation -->
<header class="sticky top-0 z-30 bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/siswa/dashboard" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 leading-tight">SRPE</p>
                    <p class="text-xs text-slate-500 leading-tight">SMKN 3 Payakumbuh</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1">
                <a href="/siswa/dashboard" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Beranda</a>
                <a href="/siswa/ekstrakurikuler" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/ekstrakurikuler*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Katalog Ekskul</a>
                <a href="/siswa/kuesioner" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/kuesioner*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Kuesioner</a>
                <a href="/siswa/rekomendasi" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/rekomendasi*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Rekomendasi</a>
                <a href="/siswa/riwayat" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/riwayat') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">Riwayat</a>
            </nav>

            <!-- Right actions -->
            <div class="flex items-center gap-2">
                @php
                    $navUser = auth()->user();
                    $navStudent = $navUser?->student;
                    $initial = strtoupper(substr($navUser?->name ?? 'S', 0, 1));
                    $shortName = \Illuminate\Support\Str::limit($navUser?->name ?? 'Siswa', 12);
                @endphp
                <!-- Profile dropdown -->
                <div class="relative" id="studentDropdown">
                    <button onclick="toggleStudentDropdown()" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-700 text-sm font-bold">{{ $initial }}</span>
                        </div>
                        <span class="hidden sm:block text-sm font-medium text-slate-700">{{ $shortName }}</span>
                        <svg class="hidden sm:block w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="studentDropdownMenu" class="hidden absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-sm font-medium text-slate-900 truncate">{{ $navUser?->name ?? 'Siswa' }}</p>
                            <p class="text-xs text-slate-500 truncate">
                                @if($navStudent?->nis)
                                    NIS: {{ $navStudent->nis }} · {{ $navStudent->class_name ?? '-' }}
                                @else
                                    {{ $navUser?->email ?? '-' }}
                                @endif
                            </p>
                        </div>
                        <a href="/siswa/profil" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profil Saya</a>
                        <a href="/siswa/pendaftaran" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Status Pendaftaran</a>
                        <hr class="my-1 border-slate-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-slate-100 bg-white">
        <nav class="px-4 py-3 space-y-1">
            <a href="/siswa/dashboard" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
            <a href="/siswa/ekstrakurikuler" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/ekstrakurikuler*') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">Katalog Ekskul</a>
            <a href="/siswa/kuesioner" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/kuesioner*') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">Kuesioner</a>
            <a href="/siswa/rekomendasi" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/rekomendasi*') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">Rekomendasi</a>
            <a href="/siswa/riwayat" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('siswa/riwayat') ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-50' }}">Riwayat</a>
            <a href="/siswa/profil" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50">Profil Saya</a>
        </nav>
    </div>
</header>

<!-- Page Content -->
<main class="min-h-[calc(100vh-4rem)] max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @if(session('success'))
        <div class="mb-4">
            <x-alert variant="success">{{ session('success') }}</x-alert>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4">
            <x-alert variant="danger">{{ session('error') }}</x-alert>
        </div>
    @endif
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white border-t border-slate-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} SRPE — SMK Negeri 3 Payakumbuh</p>
            <p class="text-xs text-amber-600">⚠ Data pada halaman ini merupakan data demo untuk keperluan pengembangan</p>
        </div>
    </div>
</footer>

<script>
function toggleStudentDropdown() {
    document.getElementById('studentDropdownMenu').classList.toggle('hidden');
}
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
document.addEventListener('click', function(e) {
    const d = document.getElementById('studentDropdown');
    if (d && !d.contains(e.target)) {
        document.getElementById('studentDropdownMenu').classList.add('hidden');
    }
});
</script>

@stack('scripts')
</body>
</html>
