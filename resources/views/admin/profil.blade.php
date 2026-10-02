@extends('layouts.admin')

@section('page-title', 'Profil Admin')

@section('content')
<div class="max-w-3xl space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Profil Administrator</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola informasi akun dan pengaturan keamanan sistem</p>
    </div>

    <!-- Admin Identity Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-xs flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <h2 class="text-lg font-bold text-slate-900">{{ Auth::user()->name ?? 'Administrator' }}</h2>
                    <span class="inline-flex items-center self-center sm:self-auto px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        Admin
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">{{ Auth::user()->email }}</p>
                <p class="text-xs text-slate-400 mt-1">Pengelola Sistem Rekomendasi Ekstrakurikuler SMKN 3 Payakumbuh</p>
            </div>
        </div>
    </div>

    <!-- Edit Profil Form -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Informasi Akun</h3>

        <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', Auth::user()->name) }}"
                    class="block w-full rounded-lg border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required
                />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Email <span class="text-red-500">*</span></label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    class="block w-full rounded-lg border @error('email') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required
                />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Security & Password Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7">
        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Keamanan &amp; Kata Sandi</h3>

        <form method="POST" action="{{ route('admin.profil.password') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Password Saat Ini <span class="text-red-500">*</span></label>
                <input
                    type="password"
                    name="current_password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border @error('current_password') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    required
                />
                @error('current_password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Password Baru <span class="text-red-500">*</span></label>
                    <input
                        type="password"
                        name="new_password"
                        placeholder="Minimal 8 karakter"
                        class="block w-full rounded-lg border @error('password') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        required
                    />
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input
                        type="password"
                        name="new_password_confirmation"
                        placeholder="Ulangi password baru"
                        class="block w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        required
                    />
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
