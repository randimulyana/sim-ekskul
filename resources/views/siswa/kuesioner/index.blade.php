@extends('layouts.student')

@section('title', 'Kuesioner Minat & Bakat')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="text-center sm:text-left">
        <h1 class="text-2xl font-bold text-slate-900">Kuesioner Pemilihan Ekstrakurikuler</h1>
        <p class="text-sm text-slate-500 mt-1">Jawab pertanyaan berikut secara jujur sesuai minat dan kondisimu untuk membantu penentuan rekomendasi ekstrakurikuler.</p>
    </div>

    @if(! $activePeriod)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center space-y-3">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-base font-bold text-amber-900">Periode Pendaftaran Sedang Ditutup</h3>
            <p class="text-sm text-amber-700 max-w-md mx-auto">
                Pengisian kuesioner hanya dapat dilakukan ketika periode pendaftaran dibuka oleh pihak sekolah. Silakan kembali lagi nanti.
            </p>
            <div class="pt-2">
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-lg transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    @elseif($questions->isEmpty())
        <div class="bg-white border border-slate-200 rounded-xl p-8 text-center space-y-3">
            <div class="w-12 h-12 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Pertanyaan Kuesioner</h3>
            <p class="text-sm text-slate-500">
                Daftar pertanyaan untuk periode {{ $activePeriod->name }} belum dikonfigurasi. Hubungi pihak admin sekolah jika masalah berlanjut.
            </p>
        </div>
    @else
        <!-- Information Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3 text-blue-900">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs space-y-1">
                <p class="font-bold">Periode Aktif: {{ $activePeriod->name }}</p>
                <p class="text-blue-700">Rekomendasi ekstrakurikuler dihasilkan sebagai saran pendukung keputusan. Kamu dapat menyimpan draf kapan saja sebelum mengirim secara final.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Stepper Progress Bar -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 sm:p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider" id="stepLabel">
                    Langkah 1 dari {{ $categories->count() }}: {{ $categories->first() }}
                </span>
                <span class="text-xs font-semibold text-slate-500" id="stepPercent">
                    {{ round((1 / max(1, $categories->count())) * 100) }}% Selesai
                </span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ round((1 / max(1, $categories->count())) * 100) }}%"></div>
            </div>

            <!-- Step Titles Pills -->
            <div class="hidden sm:grid grid-cols-{{ max(1, min(5, $categories->count())) }} gap-2 mt-4 pt-3 border-t border-slate-100 text-center">
                @foreach($categories as $idx => $cat)
                <div class="step-indicator text-xs font-medium {{ $idx === 0 ? 'text-blue-600 font-semibold' : 'text-slate-400' }}" data-step="{{ $idx + 1 }}">
                    {{ $idx + 1 }}. {{ $cat }}
                </div>
                @endforeach
            </div>
        </div>

        <!-- Kontainer Kartu Kuesioner -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form id="questionnaireForm" method="POST" action="{{ route('siswa.kuesioner.store') }}">
                @csrf
                <input type="hidden" name="is_final" id="isFinalInput" value="1">

                @php $globalQNum = 0; @endphp
                @foreach($categories as $catIdx => $categoryName)
                    @php
                        $stepNum = $catIdx + 1;
                        $catQuestions = $questions->where('category', $categoryName);
                    @endphp
                    <div class="step-section {{ $catIdx > 0 ? 'hidden' : '' }}" id="step{{ $stepNum }}">
                        <div class="mb-6 pb-4 border-b border-slate-100">
                            <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah {{ $stepNum }} dari {{ $categories->count() }}</span>
                            <h2 class="text-lg font-bold text-slate-900 mt-2">{{ $categoryName }}</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Jawab pertanyaan di bawah ini dengan memilih opsi yang paling mewakili dirimu.</p>
                        </div>

                        <div class="space-y-6">
                            @foreach($catQuestions as $q)
                                @php
                                    $globalQNum++;
                                    $qAnswer = $existingAnswers[$q->id] ?? null;
                                @endphp
                                <div>
                                    <label class="block text-sm font-semibold text-slate-800 mb-2">
                                        {{ $globalQNum }}. {{ $q->question }}
                                        @if($q->is_required)
                                            <span class="text-red-500" title="Wajib diisi">*</span>
                                        @endif
                                    </label>

                                    @if($errors->has($q->id))
                                        <p class="text-xs text-red-600 font-medium mb-2">{{ $errors->first($q->id) }}</p>
                                    @endif

                                    @if($q->type === 'radio')
                                        <div class="space-y-2">
                                            @foreach($q->options as $opt)
                                            <label class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                                                <input
                                                    type="radio"
                                                    name="answers[{{ $q->id }}]"
                                                    value="{{ $opt->id }}"
                                                    class="text-blue-600 focus:ring-blue-500"
                                                    {{ ($qAnswer && $qAnswer['option_id'] == $opt->id) ? 'checked' : '' }}
                                                >
                                                <span class="text-sm text-slate-700">{{ $opt->label }}</span>
                                            </label>
                                            @endforeach
                                        </div>

                                    @elseif($q->type === 'likert')
                                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3 font-medium">
                                                <span>{{ $q->options->first()?->label ?? '1 (Rendah)' }}</span>
                                                <span>{{ $q->options->last()?->label ?? '5 (Tinggi)' }}</span>
                                            </div>
                                            <div class="grid grid-cols-{{ max(1, $q->options->count()) }} gap-2 text-center">
                                                @foreach($q->options as $opt)
                                                <label class="cursor-pointer">
                                                    <input
                                                        type="radio"
                                                        name="answers[{{ $q->id }}]"
                                                        value="{{ $opt->id }}"
                                                        class="sr-only peer"
                                                        {{ ($qAnswer && $qAnswer['option_id'] == $opt->id) ? 'checked' : '' }}
                                                    >
                                                    <div class="py-2.5 rounded-lg border border-slate-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-sm font-bold text-slate-700 transition-colors">
                                                        {{ $opt->value ?? $loop->iteration }}
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                    @elseif($q->type === 'checkbox')
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                            @foreach($q->options as $opt)
                                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    name="answers[{{ $q->id }}][]"
                                                    value="{{ $opt->id }}"
                                                    class="rounded text-blue-600 focus:ring-blue-500"
                                                    {{ ($qAnswer && in_array($opt->id, $qAnswer['option_ids'] ?? [], false)) ? 'checked' : '' }}
                                                >
                                                <span class="text-sm text-slate-700">{{ $opt->label }}</span>
                                            </label>
                                            @endforeach
                                        </div>

                                    @elseif($q->type === 'textarea')
                                        <textarea
                                            name="answers[{{ $q->id }}]"
                                            rows="3"
                                            class="w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                            placeholder="Tuliskan pengalaman atau ceritamu secara ringkas..."
                                        >{{ $qAnswer['text'] ?? '' }}</textarea>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Navigation Buttons -->
                <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-between gap-4">
                    <button
                        type="button"
                        id="prevBtn"
                        onclick="changeStep(-1)"
                        class="hidden px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition-colors"
                    >
                        &larr; Sebelumnya
                    </button>

                    <div class="flex items-center gap-3 ml-auto">
                        <button
                            type="button"
                            onclick="saveDraft()"
                            class="px-4 py-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition-colors"
                            title="Simpan jawaban sementara tanpa menyelesaikan kuesioner"
                        >
                            Simpan Draf
                        </button>

                        <button
                            type="button"
                            id="nextBtn"
                            onclick="changeStep(1)"
                            class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition-colors"
                        >
                            Selanjutnya &rarr;
                        </button>

                        <button
                            type="button"
                            id="submitBtn"
                            onclick="submitFinal()"
                            class="hidden px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition-colors"
                        >
                            Simpan & Selesai &rarr;
                        </button>
                    </div>
                </div>

            </form>
        </div>
    @endif
</div>

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = {{ $categories->count() > 0 ? $categories->count() : 1 }};
const stepTitles = @json($categories->values()->all());

function updateUI() {
    for (let i = 1; i <= totalSteps; i++) {
        const sec = document.getElementById(`step${i}`);
        if (!sec) continue;
        if (i === currentStep) {
            sec.classList.remove('hidden');
        } else {
            sec.classList.add('hidden');
        }
    }

    const pct = Math.round((currentStep / totalSteps) * 100);
    const progressBar = document.getElementById('progressBar');
    const stepPercent = document.getElementById('stepPercent');
    const stepLabel = document.getElementById('stepLabel');

    if (progressBar) progressBar.style.width = `${pct}%`;
    if (stepPercent) stepPercent.innerText = `${pct}% Selesai`;
    if (stepLabel && stepTitles[currentStep - 1]) {
        stepLabel.innerText = `Langkah ${currentStep} dari ${totalSteps}: ${stepTitles[currentStep - 1]}`;
    }

    document.querySelectorAll('.step-indicator').forEach(ind => {
        const stepNum = parseInt(ind.getAttribute('data-step'));
        if (stepNum === currentStep) {
            ind.classList.remove('text-slate-400', 'text-emerald-600');
            ind.classList.add('text-blue-600', 'font-semibold');
        } else if (stepNum < currentStep) {
            ind.classList.remove('text-slate-400', 'text-blue-600');
            ind.classList.add('text-emerald-600', 'font-medium');
        } else {
            ind.classList.remove('text-blue-600', 'text-emerald-600', 'font-semibold');
            ind.classList.add('text-slate-400');
        }
    });

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (prevBtn) {
        if (currentStep === 1) {
            prevBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
        }
    }

    if (nextBtn && submitBtn) {
        if (currentStep === totalSteps) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }
    }

    window.scrollTo({ top: 120, behavior: 'smooth' });
}

function changeStep(direction) {
    currentStep += direction;
    if (currentStep < 1) currentStep = 1;
    if (currentStep > totalSteps) currentStep = totalSteps;
    updateUI();
}

function saveDraft() {
    const isFinalInput = document.getElementById('isFinalInput');
    if (isFinalInput) isFinalInput.value = '0';
    document.getElementById('questionnaireForm').submit();
}

function submitFinal() {
    const isFinalInput = document.getElementById('isFinalInput');
    if (isFinalInput) isFinalInput.value = '1';
    document.getElementById('questionnaireForm').submit();
}
</script>
@endpush
@endsection
