<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SRPE SMKN 3 Payakumbuh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

<!-- Sidebar Overlay (mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white border-r border-slate-200 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-bold text-slate-900 truncate">SRPE</p>
            <p class="text-xs text-slate-500 truncate">SMKN 3 Payakumbuh</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6">
        <!-- DASHBOARD -->
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">Dashboard</p>
            <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
        </div>

        <!-- DATA -->
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">Data</p>
            <div class="space-y-0.5">
                <a href="/admin/siswa" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/siswa*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Siswa
                </a>
                <a href="/admin/ekstrakurikuler" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/ekstrakurikuler*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Ekstrakurikuler
                </a>
                <a href="/admin/pendaftaran" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/pendaftaran*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Pendaftaran
                </a>
            </div>
        </div>

        <!-- REKOMENDASI -->
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">Rekomendasi</p>
            <div class="space-y-0.5">
                <a href="/admin/kriteria" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/kriteria*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Kriteria &amp; Bobot
                </a>
                <a href="/admin/kuesioner" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/kuesioner*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kuesioner
                </a>
                <a href="/admin/rekomendasi/matriks-keputusan" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/rekomendasi/matriks-keputusan*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Matriks Keputusan (5A)
                </a>
                <a href="/admin/rekomendasi" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/rekomendasi') || (request()->is('admin/rekomendasi/*') && !request()->is('admin/rekomendasi/matriks-keputusan*')) ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Hasil Rekomendasi
                </a>
            </div>
        </div>

        <!-- LAPORAN -->
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">Laporan</p>
            <a href="/admin/laporan" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/laporan') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                Laporan & Rekap
            </a>
        </div>

        <!-- SISTEM -->
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">Sistem</p>
            <div class="space-y-0.5">
                <a href="/admin/pengaturan" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/pengaturan') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Periode Pendaftaran
                </a>
                <a href="/admin/profil" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('admin/profil') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>
            </div>
        </div>
    </nav>

    <!-- User Info at bottom -->
    <div class="p-4 border-t border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-blue-700 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@smkn3payakumbuh.sch.id' }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main wrapper -->
<div class="lg:pl-64 min-h-screen flex flex-col">
    <!-- Top Navbar -->
    <header class="sticky top-0 z-10 bg-white border-b border-slate-200 px-4 lg:px-6 h-16 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <!-- Mobile menu button -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <h2 class="text-base font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h2>
                @hasSection('page-subtitle')
                    <p class="text-xs text-slate-500">@yield('page-subtitle')</p>
                @endif
            </div>
        </div>

        <!-- Right actions -->
        <div class="flex items-center gap-3">
            <!-- Notification bell -->
            <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </button>

            <!-- User dropdown -->
            <div class="relative" id="userDropdown">
                <button onclick="toggleDropdown()" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100">
                    <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-700 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <span class="hidden md:block text-sm font-medium text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="dropdownMenu" class="hidden absolute right-0 top-full mt-1 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                    <a href="/admin/profil" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profil Saya</a>
                    <hr class="my-1 border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-1 p-4 lg:p-6">
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
    <footer class="py-4 px-6 text-center text-xs text-slate-400 border-t border-slate-100">
        SRPE SMKN 3 Payakumbuh &copy; {{ date('Y') }} — Data pada sistem ini merupakan data demo
    </footer>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const isOpen = !sidebar.classList.contains('-translate-x-full');
    if (isOpen) {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    } else {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }
}

function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        document.getElementById('dropdownMenu').classList.add('hidden');
    }
});
</script>

@stack('scripts')
</body>
</html>
