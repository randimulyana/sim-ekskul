@extends('layouts.admin')
@section('page-title', 'Edit Siswa')
@section('content')
<!-- DATA DEMO -->
<div class="max-w-2xl">
    <div class="mb-6">
        <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
            <a href="/admin/dashboard" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/admin/siswa" class="hover:text-slate-700">Siswa</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-700 font-medium">Edit</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Data Siswa</h1>
        <p class="mt-1 text-sm text-slate-500">Perbarui informasi data siswa di bawah ini</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form class="space-y-5" method="POST" action="#">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="Andi Saputra"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">NIS</label>
                    <input type="text" name="nis" value="2026001"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                    <select name="kelas"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <optgroup label="BUSANA">
                            <option>BUSANA 1</option>
                            <option>BUSANA 2</option>
                            <option>BUSANA 3</option>
                            <option>BUSANA 4</option>
                        </optgroup>
                        <optgroup label="TKJ &amp; ANIMASI">
                            <option>TKJ</option>
                            <option>ANIMASI</option>
                        </optgroup>
                        <optgroup label="KULINER">
                            <option selected>KULINER 1</option>
                            <option>KULINER 2</option>
                            <option>KULINER 3</option>
                            <option>KULINER 4</option>
                        </optgroup>
                        <optgroup label="KC KULIT &amp; RAMBUT">
                            <option>KC KULIT &amp; RAMBUT 1</option>
                            <option>KC KULIT &amp; RAMBUT 2</option>
                            <option>KC SPA</option>
                        </optgroup>
                        <optgroup label="PERHOTELAN">
                            <option>PERHOTELAN 1</option>
                            <option>PERHOTELAN 2</option>
                            <option>PERHOTELAN 3</option>
                            <option>PERHOTELAN 4</option>
                        </optgroup>
                        <option>ULW</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="08123456789"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Awali dengan 08 atau +62" />
                    <p class="text-xs text-slate-500 mt-1">Format: 081234567890 atau +6281234567890</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="aktif" selected>Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    Simpan Perubahan
                </button>
                <a href="/admin/siswa"
                    class="px-6 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
