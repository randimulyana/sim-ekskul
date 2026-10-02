@extends('layouts.student')

@section('title', 'Kuesioner Minat & Bakat')

@section('content')
{{-- DATA DEMO: butir kuesioner ini merupakan draft simulasi untuk kebutuhan UI prototype sistem rekomendasi --}}

<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="text-center sm:text-left">
        <h1 class="text-2xl font-bold text-slate-900">Kuesioner Pemilihan Ekstrakurikuler</h1>
        <p class="text-sm text-slate-500 mt-1">Jawab pertanyaan berikut secara jujur sesuai minat dan kondisimu untuk mendapatkan rekomendasi yang relevan.</p>
    </div>

    <!-- Stepper Progress Bar -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 sm:p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider" id="stepLabel">Langkah 1 dari 5</span>
            <span class="text-xs font-semibold text-slate-500" id="stepPercent">20% Selesai</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2">
            <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 20%"></div>
        </div>

        <!-- Step Titles Pills -->
        <div class="hidden sm:grid grid-cols-5 gap-2 mt-4 pt-3 border-t border-slate-100 text-center">
            <div class="step-indicator active text-xs font-medium text-blue-600 font-semibold" data-step="1">1. Minat Awal</div>
            <div class="step-indicator text-xs font-medium text-slate-400" data-step="2">2. Ketertarikan</div>
            <div class="step-indicator text-xs font-medium text-slate-400" data-step="3">3. Karakteristik</div>
            <div class="step-indicator text-xs font-medium text-slate-400" data-step="4">4. Pengalaman</div>
            <div class="step-indicator text-xs font-medium text-slate-400" data-step="5">5. Kemampuan</div>
        </div>
    </div>

    <!-- Questionnaire Card Container -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form id="questionnaireForm" onsubmit="event.preventDefault(); submitForm();">

            <!-- STEP 1: Minat Awal -->
            <div class="step-section" id="step1">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah 1</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Data Diri & Preferensi Awal</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Identifikasi gaya belajar dan orientasi aktivitas harianmu.</p>
                </div>

                <div class="space-y-6">
                    <!-- Q1 -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">1. Bagaimana cara kamu belajar hal baru yang paling menyenangkan?</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="radio" name="q1" value="kinestetik" class="text-blue-600 focus:ring-blue-500" checked>
                                <span class="text-sm text-slate-700">Praktik langsung, bergerak, dan simulasi fisik (Kinestetik)</span>
                            </label>
                            <label class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="radio" name="q1" value="visual" class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Melihat gambar, demonstrasi visual, atau video (Visual)</span>
                            </label>
                            <label class="flex items-center gap-3 p-3.5 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="radio" name="q1" value="auditori" class="text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Mendengarkan penjelasan, diskusi, dan irama bunyi (Auditori)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">2. Seberapa sering kamu menyukai aktivitas yang menuntut ketahanan fisik di luar ruangan?</label>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3 font-medium">
                                <span>Sangat Jarang (1)</span>
                                <span>Netral (3)</span>
                                <span>Sangat Sering (5)</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center">
                                @foreach([1, 2, 3, 4, 5] as $val)
                                <label class="cursor-pointer">
                                    <input type="radio" name="q2_likert" value="{{ $val }}" class="sr-only peer" {{ $val === 4 ? 'checked' : '' }}>
                                    <div class="py-2.5 rounded-lg border border-slate-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-sm font-bold text-slate-700 transition-colors">
                                        {{ $val }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Ketertarikan -->
            <div class="step-section hidden" id="step2">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah 2</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Minat & Ketertarikan Spesifik</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Bidang kegiatan mana yang membuatmu antusias?</p>
                </div>

                <div class="space-y-6">
                    <!-- Q3 -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">3. Bidang kegiatan mana saja yang menarik perhatianmu? (Pilih satu atau lebih)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="kedisiplinan" checked class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Kedisiplinan & Baris-Berbaris</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="alam" checked class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Kepanduan & Petualangan Alam</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="musik" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Seni Musik & Pertunjukan</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="beladiri" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Bela Diri Tradisional</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="bahasa" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Bahasa Asing & Komunikasi</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="checkbox" name="interests[]" value="keagamaan" class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Kajian & Hafalan Al-Qur'an</span>
                            </label>
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">4. Apakah kamu senang tampil di depan umum atau audiens ramai?</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="public_performance" value="sangat_suka" checked class="text-blue-600">
                                <span class="text-sm text-slate-700">Sangat antusias dan percaya diri</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="public_performance" value="cukup" class="text-blue-600">
                                <span class="text-sm text-slate-700">Bisa menyesuaikan diri jika bersama tim</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="public_performance" value="kurang" class="text-blue-600">
                                <span class="text-sm text-slate-700">Lebih nyaman peran di balik layar</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Karakteristik Diri -->
            <div class="step-section hidden" id="step3">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah 3</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Karakteristik & Sikap Kerja</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Mengenal pola interaksi dan kebiasaanmu dalam kelompok.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">5. Dalam mengerjakan suatu target, suasana mana yang membuatmu paling produktif?</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="work_style" value="tim_besar" checked class="text-blue-600">
                                <span class="text-sm text-slate-700">Bekerja sama dalam regu besar dengan aturan dan instruksi terstruktur</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="work_style" value="tim_kecil" class="text-blue-600">
                                <span class="text-sm text-slate-700">Kelompok kecil yang fleksibel dan santai</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="work_style" value="mandiri" class="text-blue-600">
                                <span class="text-sm text-slate-700">Fokus secara mandiri dengan ritme sendiri</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">6. Seberapa patuh kamu terhadap aturan waktu dan ketepatan kehadiran (Disiplin)?</label>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3 font-medium">
                                <span>Kurang Tertib (1)</span>
                                <span>Cukup Tertib (3)</span>
                                <span>Sangat Disiplin (5)</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center">
                                @foreach([1, 2, 3, 4, 5] as $val)
                                <label class="cursor-pointer">
                                    <input type="radio" name="discipline_likert" value="{{ $val }}" class="sr-only peer" {{ $val === 5 ? 'checked' : '' }}>
                                    <div class="py-2.5 rounded-lg border border-slate-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-sm font-bold text-slate-700 transition-colors">
                                        {{ $val }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: Pengalaman -->
            <div class="step-section hidden" id="step4">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah 4</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Pengalaman Sebelumnya</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Catatan keterlibatanmu pada kegiatan di jenjang SMP/MTs.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">7. Pernahkah kamu aktif mengikuti ekstrakurikuler saat SMP/MTs?</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="past_exp" value="aktif" checked class="text-blue-600">
                                <span class="text-sm text-slate-700">Pernah aktif rutin dan ikut kegiatan/lomba</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="past_exp" value="pernah" class="text-blue-600">
                                <span class="text-sm text-slate-700">Pernah terdaftar namun hanya sesekali hadir</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="past_exp" value="belum" class="text-blue-600">
                                <span class="text-sm text-slate-700">Belum pernah mengikuti ekskul sama sekali</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">8. Ceritakan singkat pengalaman kegiatan atau bakat yang ingin kamu kembangkan (Opsional):</label>
                        <textarea rows="3" class="w-full rounded-lg border border-slate-200 p-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Contoh: Saat SMP saya pernah ikut lomba baris-berbaris tingkat kecamatan dan ingin memperdalam PBB di SMK..."></textarea>
                    </div>
                </div>
            </div>

            <!-- STEP 5: Kemampuan -->
            <div class="step-section hidden" id="step5">
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <span class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 text-xs font-bold uppercase">Langkah 5</span>
                    <h2 class="text-lg font-bold text-slate-900 mt-2">Penilaian Kemampuan Diri</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Penilaian subjektif potensi dasar untuk pemetaan kecocokan sistem.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">9. Kemampuan Fisik & Stamina (Daya tahan lari, berdiri tegak lama, olahraga berulang):</label>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3 font-medium">
                                <span>Cepat Lelah (1)</span>
                                <span>Standar (3)</span>
                                <span>Sangat Kuat (5)</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center">
                                @foreach([1, 2, 3, 4, 5] as $val)
                                <label class="cursor-pointer">
                                    <input type="radio" name="stamina_likert" value="{{ $val }}" class="sr-only peer" {{ $val === 4 ? 'checked' : '' }}>
                                    <div class="py-2.5 rounded-lg border border-slate-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-sm font-bold text-slate-700 transition-colors">
                                        {{ $val }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-800 mb-2">10. Kemampuan Kerja Sama & Kepemimpinan Tim:</label>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-3 font-medium">
                                <span>Perlu Banyak Bimbingan (1)</span>
                                <span>Cukup Mampu (3)</span>
                                <span>Sangat Siap Memimpin (5)</span>
                            </div>
                            <div class="grid grid-cols-5 gap-2 text-center">
                                @foreach([1, 2, 3, 4, 5] as $val)
                                <label class="cursor-pointer">
                                    <input type="radio" name="leadership_likert" value="{{ $val }}" class="sr-only peer" {{ $val === 5 ? 'checked' : '' }}>
                                    <div class="py-2.5 rounded-lg border border-slate-300 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 text-sm font-bold text-slate-700 transition-colors">
                                        {{ $val }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Final confirmation box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-800">
                        <p class="font-bold mb-1">Catatan Penting:</p>
                        <p>Setelah menekan tombol "Analisis Sekarang", sistem akan menghitung skor kecocokan rekomendasi berdasarkan jawabanmu. Hasil ini bersifat sebagai saran pendukung keputusan.</p>
                    </div>
                </div>
            </div>

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

                <div class="ml-auto">
                    <button
                        type="button"
                        id="nextBtn"
                        onclick="changeStep(1)"
                        class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition-colors"
                    >
                        Selanjutnya &rarr;
                    </button>

                    <button
                        type="submit"
                        id="submitBtn"
                        class="hidden px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition-colors"
                    >
                        Analisis Sekarang &rarr;
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
let currentStep = 1;
const totalSteps = 5;

const stepTitles = [
    "Data Diri & Minat Awal",
    "Minat dan Ketertarikan",
    "Karakteristik Diri",
    "Pengalaman",
    "Kemampuan"
];

function updateUI() {
    // Show/hide sections
    for (let i = 1; i <= totalSteps; i++) {
        const sec = document.getElementById(`step${i}`);
        if (i === currentStep) {
            sec.classList.remove('hidden');
        } else {
            sec.classList.add('hidden');
        }
    }

    // Update progress bar
    const pct = Math.round((currentStep / totalSteps) * 100);
    document.getElementById('progressBar').style.width = `${pct}%`;
    document.getElementById('stepPercent').innerText = `${pct}% Selesai`;
    document.getElementById('stepLabel').innerText = `Langkah ${currentStep} dari ${totalSteps}: ${stepTitles[currentStep - 1]}`;

    // Update indicators
    document.querySelectorAll('.step-indicator').forEach(ind => {
        const stepNum = parseInt(ind.getAttribute('data-step'));
        if (stepNum === currentStep) {
            ind.classList.remove('text-slate-400');
            ind.classList.add('text-blue-600', 'font-semibold');
        } else if (stepNum < currentStep) {
            ind.classList.remove('text-slate-400');
            ind.classList.add('text-emerald-600', 'font-medium');
        } else {
            ind.classList.remove('text-blue-600', 'text-emerald-600', 'font-semibold');
            ind.classList.add('text-slate-400');
        }
    });

    // Buttons visibility
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (currentStep === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }

    if (currentStep === totalSteps) {
        nextBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        submitBtn.classList.add('hidden');
    }

    window.scrollTo({ top: 120, behavior: 'smooth' });
}

function changeStep(direction) {
    currentStep += direction;
    if (currentStep < 1) currentStep = 1;
    if (currentStep > totalSteps) currentStep = totalSteps;
    updateUI();
}

function submitForm() {
    window.location.href = '/siswa/kuesioner/analisis';
}
</script>
@endpush
@endsection
