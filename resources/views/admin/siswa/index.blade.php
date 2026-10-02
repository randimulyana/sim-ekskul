@extends('layouts.admin')
@section('page-title', 'Data Siswa')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Siswa</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data siswa terdaftar di sistem SRPE</p>
        </div>
        <a href="{{ route('admin.siswa.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Siswa
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="class" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-700">
                <option value="">Semua Kelas</option>
                @foreach($classes ?? [] as $cls)
                    <option value="{{ $cls }}" {{ request('class') === $cls ? 'selected' : '' }}>{{ $cls }}</option>
                @endforeach
            </select>
            <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-slate-700">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="inline-flex items-center gap-2 text-sm text-slate-700 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-lg hover:bg-slate-100 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['search', 'class', 'status']))
                <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center justify-center text-sm text-slate-500 hover:text-slate-800 px-3 py-2.5">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-900">{{ isset($students) ? $students->count() : 0 }}</span> dari <span class="font-semibold text-slate-900">{{ isset($students) ? $students->total() : 0 }}</span> siswa
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIS</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">WhatsApp</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students ?? [] as $index => $s)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ ($students->firstItem() ?? 1) + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($s->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <span class="font-medium text-slate-900 block">{{ $s->user->name ?? '-' }}</span>
                                    <span class="text-xs text-slate-400 block">{{ $s->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 font-mono text-xs">{{ $s->nis }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $s->class_name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $s->whatsapp ?: '-' }}</td>
                        <td class="px-6 py-4">
                            @if($s->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.siswa.show', $s->id) }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium hover:underline">Lihat</a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('admin.siswa.edit', $s->id) }}" class="text-xs text-slate-600 hover:text-slate-700 font-medium hover:underline">Edit</a>
                                <span class="text-slate-300">|</span>
                                <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-medium hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data siswa yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($students) && $students->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
