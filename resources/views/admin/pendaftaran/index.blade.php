@extends('layouts.admin')

@section('page-title', 'Kelola Pendaftaran')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Pendaftaran Siswa</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola dan periksa pengajuan pemilihan ekstrakurikuler siswa periode aktif</p>
        </div>
        <div class="flex items-center gap-2">
            @php
            $activePeriod = \App\Models\Period::where('is_active', true)->first();
            @endphp
            @if($activePeriod)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Periode Aktif: {{ $activePeriod->school_year }}
            </span>
            @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                Belum ada periode aktif
            </span>
            @endif
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 space-y-3">
        <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <!-- Search -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Cari Siswa</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama siswa atau NIS..."
                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500"
                />
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Status</label>
                <select name="status" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="">Semua Status</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Terkirim (Submitted)</option>
                    <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Ditinjau (Reviewed)</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima (Accepted)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <!-- Filter Ekskul -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Ekstrakurikuler</label>
                <select name="ekskul" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="">Semua Ekskul</option>
                    @foreach($extracurriculars ?? [] as $eks)
                        <option value="{{ $eks->id }}" {{ request('ekskul') == $eks->id ? 'selected' : '' }}>{{ $eks->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Kelas -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase mb-1">Kelas</label>
                <select name="class" class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-xs text-slate-900 focus:outline-none focus:ring-1 focus:ring-blue-500 bg-white">
                    <option value="">Semua Kelas</option>
                    @foreach($classes ?? [] as $cls)
                        <option value="{{ $cls }}" {{ request('class') === $cls ? 'selected' : '' }}>{{ $cls }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'ekskul', 'class']))
                    <a href="{{ route('admin.pendaftaran.index') }}" class="px-3 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-medium rounded-lg text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Daftar Pendaftar (Total: {{ isset($registrations) ? $registrations->total() : 0 }} Pengajuan)</h3>
            <span class="text-xs text-slate-400">Menampilkan {{ isset($registrations) ? $registrations->count() : 0 }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Siswa</th>
                        <th class="px-6 py-3.5">Kelas</th>
                        <th class="px-6 py-3.5">Pilihan Ekskul</th>
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                    $sc = [
                        'accepted'  => ['badge' => 'bg-emerald-100 text-emerald-800', 'label' => 'Diterima'],
                        'reviewed'  => ['badge' => 'bg-amber-100 text-amber-800',     'label' => 'Ditinjau'],
                        'submitted' => ['badge' => 'bg-blue-100 text-blue-800',       'label' => 'Terkirim'],
                        'rejected'  => ['badge' => 'bg-red-100 text-red-800',         'label' => 'Ditolak'],
                        'cancelled' => ['badge' => 'bg-slate-100 text-slate-800',     'label' => 'Dibatalkan'],
                    ];
                    @endphp
                    @forelse($registrations ?? [] as $i => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 text-slate-400 font-mono">{{ ($registrations->firstItem() ?? 1) + $i }}</td>
                        <td class="px-6 py-3.5">
                            <span class="font-bold text-slate-900 block text-xs">{{ $row->student->user->name ?? '-' }}</span>
                            <span class="text-slate-400 font-mono text-[11px]">NIS: {{ $row->student->nis ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-slate-700 font-medium">{{ $row->student->class_name ?? '-' }}</td>
                        <td class="px-6 py-3.5 font-semibold text-slate-800">{{ $row->extracurricular->name ?? '-' }}</td>
                        <td class="px-6 py-3.5 text-slate-500">{{ $row->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $sc[$row->status]['badge'] ?? 'bg-slate-100 text-slate-800' }}">
                                {{ $sc[$row->status]['label'] ?? ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <a href="{{ route('admin.pendaftaran.show', $row->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-bold">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Tidak ada data pendaftaran yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($registrations) && $registrations->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $registrations->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
