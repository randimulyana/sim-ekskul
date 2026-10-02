@extends('layouts.student')

@section('title', 'Profil Saya')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Profil Saya</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan data pribadimu</p>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-800 text-xs rounded-xl p-4 space-y-1">
            <div class="font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Terjadi kesalahan pengisian form:</span>
            </div>
            <ul class="list-disc list-inside pl-4 text-red-700">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===================== AVATAR & NAMA ===================== --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-5">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            {{-- Avatar circle --}}
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">NIS: {{ $student->nis ?: '-' }} · Kelas: {{ $student->class_name ?: '-' }}</p>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2 mt-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Siswa Aktif
                    </span>
                    @if($student->class_name)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-50 text-slate-600 border border-slate-200">
                        {{ $student->class_name }}
                    </span>
                    @endif
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
    <div id="viewMode" class="space-y-5 {{ $errors->any() ? 'hidden' : '' }}">

        {{-- Data Pribadi --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Data Pribadi
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
                    <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">NIS</p>
                    <p class="text-sm font-medium text-slate-900">{{ $student->nis ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Kelas</p>
                    <p class="text-sm font-medium text-slate-900">{{ $student->class_name ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">No. WhatsApp</p>
                    <p class="text-sm font-medium text-slate-900">{{ $student->whatsapp ?: '-' }}</p>
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
                    <p class="text-sm font-medium text-slate-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Tanggal Bergabung</p>
                    <p class="text-sm font-medium text-slate-900">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Peran</p>
                    <p class="text-sm font-medium text-slate-900">Siswa</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Status Kuesioner</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $questionnaireProgress['is_complete'] ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $questionnaireProgress['status_label'] }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== EDIT MODE FORM ===================== --}}
    <div id="editMode" class="{{ $errors->any() ? '' : 'hidden' }} space-y-5">

        <form method="POST" action="{{ route('siswa.profil.update') }}" class="space-y-5">
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
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">NIS</label>
                        <input type="text" value="{{ $student->nis ?: '-' }}" disabled class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">NIS dikelola oleh pihak sekolah</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Kelas</label>
                        <input type="text" value="{{ $student->class_name ?: '-' }}" disabled class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">Kelas dikelola oleh pihak sekolah</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">No. WhatsApp</label>
                        <input type="tel" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp) }}" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="bg-white rounded-xl border border-blue-200 shadow-sm p-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    Ganti Password
                </h3>
                <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password akun</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Password Baru</label>
                        <input type="password" name="password" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Ulangi password baru">
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
        editMode.classList.add('hidden');
        viewMode.classList.remove('hidden');
        btnToggle.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Edit Profil`;
    } else {
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        btnToggle.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Batal Edit`;
    }
}
</script>
@endpush
