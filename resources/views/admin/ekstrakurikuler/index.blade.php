@extends('layouts.admin')
@section('page-title', 'Ekstrakurikuler')
@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Ekstrakurikuler</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola daftar ekstrakurikuler yang tersedia &mdash;
                <span class="text-amber-600 font-medium">⚠ Data observasi awal, dapat diverifikasi bersama pihak sekolah</span>
            </p>
        </div>
        <a href="{{ route('admin.ekstrakurikuler.create') }}"
            class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Ekskul
        </a>
    </div>

    {{-- Summary Cards --}}
    @php
    $totalEkskul = \App\Models\Extracurricular::count();
    $totalAktif   = \App\Models\Extracurricular::where('is_active', true)->count();
    $totalNonaktif = \App\Models\Extracurricular::where('is_active', false)->count();
    $totalPeserta = \App\Models\Registration::count();
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Ekskul</p>
            <p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalEkskul }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Ekskul Aktif</p>
            <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $totalAktif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Nonaktif</p>
            <p class="mt-1 text-3xl font-bold text-slate-400">{{ $totalNonaktif }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Pendaftar</p>
            <p class="mt-1 text-3xl font-bold text-blue-600">{{ $totalPeserta }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.ekstrakurikuler.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi..."
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
            </div>
            <select name="category" class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                <option value="">Semua Kategori</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.ekstrakurikuler.index') }}" class="px-3 py-2 text-slate-500 hover:text-slate-800 text-sm flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Ekstrakurikuler</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembina</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Peserta</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($extracurriculars ?? [] as $i => $e)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">{{ ($extracurriculars->firstItem() ?? 1) + $i }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $e->name }}</p>
                            @if($e->schedule)
                                <p class="text-xs text-slate-400 mt-0.5">{{ $e->schedule }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $e->category ?: '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $e->coach_name ?: '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $e->registrations_count }} orang</td>
                        <td class="px-6 py-4">
                            @if($e->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.ekstrakurikuler.show', $e->id) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('admin.ekstrakurikuler.edit', $e->id) }}" class="text-sm text-slate-600 hover:text-slate-900">Edit</a>
                                <span class="text-slate-300">|</span>
                                <form method="POST" action="{{ route('admin.ekstrakurikuler.destroy', $e->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data ekstrakurikuler yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($extracurriculars) && $extracurriculars->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $extracurriculars->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
