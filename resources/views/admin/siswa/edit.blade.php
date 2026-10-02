@extends('layouts.admin')
@section('page-title', 'Edit Siswa')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <nav class="flex items-center gap-1 text-sm text-slate-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-700">Dashboard</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.siswa.index') }}" class="hover:text-slate-700">Siswa</a>
            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-700 font-medium">Edit</span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900">Edit Data Siswa</h1>
        <p class="mt-1 text-sm text-slate-500">Perbarui informasi data siswa di bawah ini</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <form class="space-y-5" method="POST" action="{{ route('admin.siswa.update', $student->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $student->user->name ?? '') }}" required
                        class="block w-full rounded-lg border @error('name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">NIS <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis) }}" required
                        class="block w-full rounded-lg border @error('nis') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    @error('nis')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="class_name" required
                        class="block w-full rounded-lg border @error('class_name') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        @php
                        $selectedClass = old('class_name', $student->class_name);
                        @endphp
                        <optgroup label="Jurusan Kuliner">
                            <option value="KULINER 1" {{ $selectedClass === 'KULINER 1' ? 'selected' : '' }}>KULINER 1</option>
                            <option value="KULINER 2" {{ $selectedClass === 'KULINER 2' ? 'selected' : '' }}>KULINER 2</option>
                            <option value="KULINER 3" {{ $selectedClass === 'KULINER 3' ? 'selected' : '' }}>KULINER 3</option>
                            <option value="KULINER 4" {{ $selectedClass === 'KULINER 4' ? 'selected' : '' }}>KULINER 4</option>
                        </optgroup>
                        <optgroup label="Jurusan Busana">
                            <option value="BUSANA 1" {{ $selectedClass === 'BUSANA 1' ? 'selected' : '' }}>BUSANA 1</option>
                            <option value="BUSANA 2" {{ $selectedClass === 'BUSANA 2' ? 'selected' : '' }}>BUSANA 2</option>
                            <option value="BUSANA 3" {{ $selectedClass === 'BUSANA 3' ? 'selected' : '' }}>BUSANA 3</option>
                            <option value="BUSANA 4" {{ $selectedClass === 'BUSANA 4' ? 'selected' : '' }}>BUSANA 4</option>
                        </optgroup>
                        <optgroup label="Jurusan Perhotelan">
                            <option value="PERHOTELAN 1" {{ $selectedClass === 'PERHOTELAN 1' ? 'selected' : '' }}>PERHOTELAN 1</option>
                            <option value="PERHOTELAN 2" {{ $selectedClass === 'PERHOTELAN 2' ? 'selected' : '' }}>PERHOTELAN 2</option>
                            <option value="PERHOTELAN 3" {{ $selectedClass === 'PERHOTELAN 3' ? 'selected' : '' }}>PERHOTELAN 3</option>
                            <option value="PERHOTELAN 4" {{ $selectedClass === 'PERHOTELAN 4' ? 'selected' : '' }}>PERHOTELAN 4</option>
                        </optgroup>
                        <optgroup label="Jurusan TKJ & Animasi">
                            <option value="TKJ" {{ $selectedClass === 'TKJ' ? 'selected' : '' }}>TKJ</option>
                            <option value="ANIMASI" {{ $selectedClass === 'ANIMASI' ? 'selected' : '' }}>ANIMASI</option>
                        </optgroup>
                        <optgroup label="Jurusan Tata Kecantikan">
                            <option value="KC KULIT & RAMBUT 1" {{ $selectedClass === 'KC KULIT & RAMBUT 1' ? 'selected' : '' }}>KC KULIT & RAMBUT 1</option>
                            <option value="KC KULIT & RAMBUT 2" {{ $selectedClass === 'KC KULIT & RAMBUT 2' ? 'selected' : '' }}>KC KULIT & RAMBUT 2</option>
                            <option value="KC SPA" {{ $selectedClass === 'KC SPA' ? 'selected' : '' }}>KC SPA</option>
                        </optgroup>
                        <optgroup label="Jurusan Lainnya">
                            <option value="ULW" {{ $selectedClass === 'ULW' ? 'selected' : '' }}>ULW</option>
                        </optgroup>
                    </select>
                    @error('class_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp) }}"
                        class="block w-full rounded-lg border @error('whatsapp') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        placeholder="Awali dengan 08 atau +62" />
                    <p class="text-xs text-slate-500 mt-1">Format: 081234567890 atau +6281234567890</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Siswa</label>
                    <input type="email" name="email" value="{{ old('email', $student->user->email ?? '') }}"
                        class="block w-full rounded-lg border @error('email') border-red-500 bg-red-50 @else border-slate-200 @enderror px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status"
                        class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="aktif" {{ old('status', $student->status) === 'active' || old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $student->status) === 'inactive' || old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.siswa.index') }}"
                    class="px-6 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
