@extends('layouts.student')

@section('title', 'Menganalisis Rekomendasi')

@section('content')
{{-- DATA DEMO: halaman transisi analisis rekomendasi simulasi visual prototype --}}

<div class="min-h-[60vh] flex items-center justify-center">
    <div class="max-w-md w-full mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center space-y-6">

        <!-- Animated Spinner -->
        <div class="relative w-20 h-20 mx-auto">
            <div class="w-20 h-20 rounded-full border-4 border-slate-100 border-t-blue-600 animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold text-slate-900">Menganalisis Jawaban Kamu...</h2>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Sistem sedang memetakan preferensi kuesioner dengan kriteria karakteristik ekstrakurikuler SMKN 3 Payakumbuh.</p>
        </div>

        <!-- Simulated Steps Progress -->
        <div class="space-y-3 text-left bg-slate-50 rounded-xl p-4 border border-slate-200/70 text-xs">
            <div class="flex items-center gap-2.5 text-emerald-600 font-medium">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Validasi kelengkapan jawaban kuesioner</span>
            </div>
            <div class="flex items-center gap-2.5 text-blue-600 font-semibold" id="stepProc1">
                <svg class="w-4 h-4 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                <span id="textProc1">Menghitung skor kecocokan preferensi...</span>
            </div>
            <div class="flex items-center gap-2.5 text-slate-400 font-medium" id="stepProc2">
                <span class="w-4 h-4 rounded-full border border-slate-300 flex items-center justify-center text-[10px]">3</span>
                <span>Menyusun ranking rekomendasi ekskul</span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div id="simulatedBar" class="bg-blue-600 h-2 rounded-full transition-all duration-700" style="width: 15%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-2 font-medium">Mohon tunggu sebentar, kamu akan dialihkan otomatis...</p>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bar = document.getElementById('simulatedBar');
    const step1 = document.getElementById('stepProc1');
    const text1 = document.getElementById('textProc1');
    const step2 = document.getElementById('stepProc2');

    // Stage 1
    setTimeout(() => {
        bar.style.width = '65%';
    }, 800);

    // Stage 2
    setTimeout(() => {
        step1.innerHTML = `<svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="text-emerald-600 font-medium">Skor kecocokan berhasil diproses</span>`;
        step2.className = "flex items-center gap-2.5 text-blue-600 font-semibold";
        step2.innerHTML = `<svg class="w-4 h-4 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg><span>Menyusun ranking rekomendasi ekskul...</span>`;
        bar.style.width = '95%';
    }, 1800);

    // Redirect to hasil
    setTimeout(() => {
        bar.style.width = '100%';
        window.location.href = '/siswa/kuesioner/hasil';
    }, 2800);
});
</script>
@endpush
@endsection
