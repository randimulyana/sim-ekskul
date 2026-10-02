@extends('layouts.admin')
@section('page-title', 'Tambah Siswa')
@section('content')
<!-- DATA DEMO: data di halaman ini adalah contoh untuk keperluan pengembangan sistem -->
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="/admin/siswa" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 transition-colors">
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
            <form action="/admin/siswa" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap siswa"
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400">
                </div>

                {{-- NIS — dengan error state demo --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        NIS (Nomor Induk Siswa) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nis" value="20240" placeholder="Contoh: 2024001"
                           class="w-full px-4 py-2.5 text-sm border border-red-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent text-slate-900 bg-red-50">
                    {{-- UI Demo: error state --}}
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        NIS tidak valid. Harus terdiri dari 7 digit angka.
                    </p>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-slate-900">
                        <option value="" class="text-slate-400">-- Pilih Kelas --</option>
                        <optgroup label="Jurusan Kuliner">
                            <option>KULINER 1</option>
                            <option>KULINER 2</option>
                            <option>KULINER 3</option>
                        </optgroup>
                        <optgroup label="Jurusan Busana">
                            <option>BUSANA 1</option>
                            <option>BUSANA 2</option>
                        </optgroup>
                        <optgroup label="Jurusan Perhotelan">
                            <option>PERHOTELAN 1</option>
                            <option>PERHOTELAN 2</option>
                        </optgroup>
                        <optgroup label="Jurusan TKJ">
                            <option>TKJ 1</option>
                            <option>TKJ 2</option>
                        </optgroup>
                        <optgroup label="Jurusan Animasi">
                            <option>ANIMASI 1</option>
                        </optgroup>
                        <optgroup label="Jurusan Akuntansi">
                            <option>AKUNTANSI 1</option>
                            <option>AKUNTANSI 2</option>
                        </optgroup>
                        <optgroup label="Jurusan Pemasaran">
                            <option>PEMASARAN 1</option>
                        </optgroup>
                    </select>
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Nomor WhatsApp
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-slate-500 bg-slate-50 border border-r-0 border-slate-200 rounded-l-lg">+62</span>
                        <input type="tel" name="whatsapp" placeholder="812-3456-7890"
                               class="flex-1 px-4 py-2.5 text-sm border border-slate-200 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 placeholder-slate-400">
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Gunakan format tanpa angka 0 di depan. Contoh: 812-3456-7890</p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="aktif" checked class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-slate-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="nonaktif" class="text-blue-600 focus:ring-blue-500">
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
                    <a href="/admin/siswa"
                       class="inline-flex items-center justify-center gap-2 text-sm font-medium text-slate-600 border border-slate-200 px-6 py-2.5 rounded-lg hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
