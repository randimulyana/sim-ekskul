@extends('layouts.admin')
@section('page-title', 'Tambah Siswa')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-sm text-slate-500">Tambah Siswa</span>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-semibold text-slate-900">Form Tambah Data Siswa</h2>
                <p class="text-sm text-slate-500 mt-0.5">Lengkapi informasi siswa berikut untuk menambahkan ke sistem</p>
            </div>
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', old('nama')) }}" placeholder="Masukkan nama lengkap siswa" required
                           class="w-full px-4 py-2.5 text-sm border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 placeholder-slate-400">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIS --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        NIS (Nomor Induk Siswa) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 2026001" required
                           class="w-full px-4 py-2.5 text-sm border @error('nis') border-red-500 bg-red-50 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 placeholder-slate-400">
                    @error('nis')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="class_name" required class="w-full px-4 py-2.5 text-sm border @error('class_name') border-red-500 bg-red-50 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-900">
                        <option value="" class="text-slate-400">-- Pilih Kelas --</option>
                        <optgroup label="Jurusan Kuliner">
                            <option value="KULINER 1" {{ old('class_name', old('kelas')) === 'KULINER 1' ? 'selected' : '' }}>KULINER 1</option>
                            <option value="KULINER 2" {{ old('class_name', old('kelas')) === 'KULINER 2' ? 'selected' : '' }}>KULINER 2</option>
                            <option value="KULINER 3" {{ old('class_name', old('kelas')) === 'KULINER 3' ? 'selected' : '' }}>KULINER 3</option>
                            <option value="KULINER 4" {{ old('class_name', old('kelas')) === 'KULINER 4' ? 'selected' : '' }}>KULINER 4</option>
                        </optgroup>
                        <optgroup label="Jurusan Busana">
                            <option value="BUSANA 1" {{ old('class_name', old('kelas')) === 'BUSANA 1' ? 'selected' : '' }}>BUSANA 1</option>
                            <option value="BUSANA 2" {{ old('class_name', old('kelas')) === 'BUSANA 2' ? 'selected' : '' }}>BUSANA 2</option>
                            <option value="BUSANA 3" {{ old('class_name', old('kelas')) === 'BUSANA 3' ? 'selected' : '' }}>BUSANA 3</option>
                            <option value="BUSANA 4" {{ old('class_name', old('kelas')) === 'BUSANA 4' ? 'selected' : '' }}>BUSANA 4</option>
                        </optgroup>
                        <optgroup label="Jurusan Perhotelan">
                            <option value="PERHOTELAN 1" {{ old('class_name', old('kelas')) === 'PERHOTELAN 1' ? 'selected' : '' }}>PERHOTELAN 1</option>
                            <option value="PERHOTELAN 2" {{ old('class_name', old('kelas')) === 'PERHOTELAN 2' ? 'selected' : '' }}>PERHOTELAN 2</option>
                            <option value="PERHOTELAN 3" {{ old('class_name', old('kelas')) === 'PERHOTELAN 3' ? 'selected' : '' }}>PERHOTELAN 3</option>
                            <option value="PERHOTELAN 4" {{ old('class_name', old('kelas')) === 'PERHOTELAN 4' ? 'selected' : '' }}>PERHOTELAN 4</option>
                        </optgroup>
                        <optgroup label="Jurusan TKJ & Animasi">
                            <option value="TKJ" {{ old('class_name', old('kelas')) === 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="ANIMASI" {{ old('class_name', old('kelas')) === 'ANIMASI' ? 'selected' : '' }}>ANIMASI</option>
                        </optgroup>
                        <optgroup label="Jurusan Tata Kecantikan">
                            <option value="KC KULIT & RAMBUT 1" {{ old('class_name', old('kelas')) === 'KC KULIT & RAMBUT 1' ? 'selected' : '' }}>KC KULIT & RAMBUT 1</option>
                            <option value="KC KULIT & RAMBUT 2" {{ old('class_name', old('kelas')) === 'KC KULIT & RAMBUT 2' ? 'selected' : '' }}>KC KULIT & RAMBUT 2</option>
                            <option value="KC SPA" {{ old('class_name', old('kelas')) === 'KC SPA' ? 'selected' : '' }}>KC SPA</option>
                        </optgroup>
                        <optgroup label="Jurusan Lainnya">
                            <option value="ULW" {{ old('class_name', old('kelas')) === 'ULW' ? 'selected' : '' }}>ULW</option>
                        </optgroup>
                    </select>
                    @error('class_name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nomor WhatsApp
                    </label>
                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Contoh: 08123456789"
                           class="w-full px-4 py-2.5 text-sm border @error('whatsapp') border-red-500 bg-red-50 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 placeholder-slate-400">
                    <p class="mt-1.5 text-xs text-slate-400">Format: 08xxxxxxxxxx atau +62xxxxxxxxxx</p>
                    @error('whatsapp')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email (Opsional) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Email Akun Siswa (Opsional)
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Otomatis dibuat dari NIS jika dikosongkan"
                           class="w-full px-4 py-2.5 text-sm border @error('email') border-red-500 bg-red-50 @else border-slate-200 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 placeholder-slate-400">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="nonaktif" {{ old('status') === 'nonaktif' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-slate-700">Nonaktif</span>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data Siswa
                    </button>
                    <a href="{{ route('admin.siswa.index') }}"
                       class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 border border-slate-200 px-6 py-2.5 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
