@extends('layouts.student')

@section('title', 'Profil Saya')

@section('content')
{{-- DATA DEMO: semua data di halaman ini adalah dummy untuk keperluan pengembangan --}}

<div class="max-w-2xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Profil Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan data pribadimu</p>
    </div>

    {{-- ===================== AVATAR & NAMA ===================== --}}
    <!-- DATA DEMO: data siswa -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-5">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            {{-- Avatar circle --}}
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                <span class="text-2xl font-bold text-white">AS</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-lg font-bold text-slate-900">Andi Saputra</h2>
                <p class="text-sm text-slate-500">NIS: 2026001 · Kelas KULINER 1</p>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Siswa Aktif
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-50 text-slate-600 border border-slate-200">
                        KULINER 1
                    </span>
                </div>
            </div>
            {{-- Edit toggle button --}}
            <button id="btnEditToggle" onclick="toggleEditMode()" class="flex-shrink-0 flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Profil
            </button>
        </div>
    </div>

    {{-- ===================== INFO DISPLAY MODE ===================== --}}
    <div id="viewMode" class="space-y-5">

        {{-- Data Pribadi --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Data Pribadi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">Andi Saputra</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">NIS</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">2026001</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Kelas</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">KULINER 1</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">No. WhatsApp</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">08123456789</p>
                </div>
            </div>
        </div>

        {{-- Data Akun --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Informasi Akun
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Email</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">andi.saputra@smkn3payakumbuh.sch.id</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Tanggal Bergabung</p>
                    <!-- DATA DEMO -->
                    <p class="text-sm font-medium text-slate-900">1 Juli 2026</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Peran</p>
                    <p class="text-sm font-medium text-slate-900">Siswa</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Status Kuesioner</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Belum Diisi</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== EDIT MODE FORM ===================== --}}
    <div id="editMode" class="hidden space-y-5">

        <form method="POST" action="/siswa/profil" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Data Pribadi Edit --}}
            <div class="bg-white rounded-xl border border-blue-200 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Edit Data Pribadi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                        <!-- DATA DEMO -->
                        <input type="text" name="name" value="Andi Saputra" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">NIS</label>
                        <!-- DATA DEMO -->
                        <input type="text" name="nis" value="2026001" disabled class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">NIS tidak dapat diubah</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Kelas</label>
                        <!-- DATA DEMO -->
                        <input type="text" name="kelas" value="KULINER 1" disabled class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">Kelas tidak dapat diubah</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">No. WhatsApp</label>
                        <!-- DATA DEMO -->
                        <input type="tel" name="whatsapp" value="08123456789" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="bg-white rounded-xl border border-blue-200 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    Ganti Password
                </h3>
                <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="••••••••">
                    </div>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <button type="button" onclick="toggleEditMode()" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-2.5 border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 transition-colors">
                    Batal
                </button>
            </div>
        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
function toggleEditMode() {
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    const btnToggle = document.getElementById('btnEditToggle');

    const isEditing = !editMode.classList.contains('hidden');

    if (isEditing) {
        // Switch to view mode
        editMode.classList.add('hidden');
        viewMode.classList.remove('hidden');
        btnToggle.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit Profil`;
    } else {
        // Switch to edit mode
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        btnToggle.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Batal Edit`;
    }
}
</script>
@endpush
