<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KonfigurasiKriteriaService
{
    /**
     * Definisi kriteria yang diusulkan untuk SRPE SMKN 3 Payakumbuh.
     * Semua item diklasifikasikan sebagai PROPOSED / NEEDS VALIDATION.
     */
    public const PROPOSED_CRITERIA = [
        [
            'code' => 'C1',
            'name' => 'Minat',
            'description' => 'Menggambarkan tingkat ketertarikan siswa terhadap aktivitas yang berkaitan dengan suatu ekstrakurikuler. [PROPOSED / NEEDS VALIDATION]',
            'type' => 'benefit',
            'weight' => 0.30,
            'status' => 'proposed',
        ],
        [
            'code' => 'C2',
            'name' => 'Kemampuan',
            'description' => 'Menggambarkan tingkat kemampuan atau keyakinan siswa terhadap kemampuan yang relevan dengan aktivitas ekstrakurikuler. [PROPOSED / NEEDS VALIDATION]',
            'type' => 'benefit',
            'weight' => 0.25,
            'status' => 'proposed',
        ],
        [
            'code' => 'C3',
            'name' => 'Karakteristik Diri',
            'description' => 'Menggambarkan kecenderungan karakter atau cara siswa beraktivitas yang relevan dengan kegiatan ekstrakurikuler. [PROPOSED / NEEDS VALIDATION]',
            'type' => 'benefit',
            'weight' => 0.20,
            'status' => 'proposed',
        ],
        [
            'code' => 'C4',
            'name' => 'Pengalaman',
            'description' => 'Menggambarkan pengalaman siswa sebelumnya yang berkaitan dengan aktivitas ekstrakurikuler. [PROPOSED / NEEDS VALIDATION]',
            'type' => 'benefit',
            'weight' => 0.15,
            'status' => 'proposed',
        ],
        [
            'code' => 'C5',
            'name' => 'Preferensi Aktivitas',
            'description' => 'Menggambarkan jenis aktivitas yang lebih disukai siswa. [PROPOSED / NEEDS VALIDATION]',
            'type' => 'benefit',
            'weight' => 0.10,
            'status' => 'proposed',
        ],
    ];

    /**
     * Nilai target untuk 12 ekstrakurikuler pada kriteria C1–C5.
     * Didokumentasikan sebagai KONFIGURASI DESAIN / RISET (Research Baseline untuk SMKN 3 Payakumbuh).
     */
    public const RESEARCH_TARGET_MAPPINGS = [
        'PASKIBRAKA'    => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 5.0, 'C4' => 3.0, 'C5' => 5.0],
        'PRAMUKA'       => ['C1' => 4.0, 'C2' => 3.0, 'C3' => 5.0, 'C4' => 4.0, 'C5' => 5.0],
        'PIK-R'         => ['C1' => 4.0, 'C2' => 3.0, 'C3' => 5.0, 'C4' => 3.0, 'C5' => 4.0],
        'SILAT TRADISI' => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 5.0],
        'RANDAI'        => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 5.0],
        'MARCHING BAND' => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 5.0, 'C4' => 3.0, 'C5' => 5.0],
        'MODELLING'     => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 5.0],
        'KESENIAN'      => ['C1' => 5.0, 'C2' => 3.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 5.0],
        'PADUAN SUARA'  => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 5.0],
        'ENGLISH CLUB'  => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 4.0],
        'JAPANESE CLUB' => ['C1' => 5.0, 'C2' => 3.0, 'C3' => 4.0, 'C4' => 3.0, 'C5' => 4.0],
        'TAHFIDZ'       => ['C1' => 5.0, 'C2' => 4.0, 'C3' => 5.0, 'C4' => 4.0, 'C5' => 4.0],
    ];

    /**
     * Standard proposed scale 1-5 for criterion values.
     */
    public const STANDARD_SCALE = [
        ['value' => 1.0, 'label' => 'Sangat Rendah', 'sort_order' => 1],
        ['value' => 2.0, 'label' => 'Rendah', 'sort_order' => 2],
        ['value' => 3.0, 'label' => 'Sedang', 'sort_order' => 3],
        ['value' => 4.0, 'label' => 'Tinggi', 'sort_order' => 4],
        ['value' => 5.0, 'label' => 'Sangat Tinggi', 'sort_order' => 5],
    ];

    /**
     * Seed atau sinkronisasi kriteria yang diusulkan, nilai indikator, dan pemetaan pertanyaan.
     */
    public function setupProposedConfiguration(): array
    {
        return DB::transaction(function () {
            $createdCriteria = [];

            // 1. Setup Criteria & Criterion Values (1-5)
            foreach (self::PROPOSED_CRITERIA as $critData) {
                $criterion = Criterion::updateOrCreate(
                    ['code' => $critData['code']],
                    [
                        'name' => $critData['name'],
                        'description' => $critData['description'],
                        'type' => $critData['type'],
                        'weight' => $critData['weight'],
                        'status' => $critData['status'],
                        'is_active' => true,
                    ]
                );

                $createdCriteria[$critData['code']] = $criterion;

                // Create or sync 5 indicator values
                foreach (self::STANDARD_SCALE as $scale) {
                    CriterionValue::updateOrCreate(
                        [
                            'criterion_id' => $criterion->id,
                            'value' => $scale['value'],
                        ],
                        [
                            'label' => $scale['label'],
                            'sort_order' => $scale['sort_order'],
                            'description' => "Skala {$scale['value']} ({$scale['label']}) untuk kriteria {$criterion->name} [PROPOSED / NEEDS VALIDATION]",
                        ]
                    );
                }
            }

            // 2. Map Existing Questions to Criteria where clearly appropriate
            $this->mapQuestionsToCriteria($createdCriteria);

            // 3. Map Question Options to Criterion Values where matching
            $this->mapQuestionOptionsToCriterionValues($createdCriteria);

            return $createdCriteria;
        });
    }

    /**
     * Atur pemetaan target penelitian untuk 12 ekstrakurikuler pada kriteria C1–C5.
     * Semua pemetaan diberi status 'validated' sebagai baseline konfigurasi riset/desain.
     */
    public function setupResearchTargetMappings(): int
    {
        return DB::transaction(function () {
            $criteria = Criterion::whereIn('code', ['C1', 'C2', 'C3', 'C4', 'C5'])->get()->keyBy('code');
            $createdCount = 0;

            foreach (self::RESEARCH_TARGET_MAPPINGS as $ekskulName => $targetValues) {
                $ekskul = Extracurricular::where('name', $ekskulName)
                    ->orWhere('slug', Str::slug($ekskulName))
                    ->first();

                if (! $ekskul) {
                    continue;
                }

                foreach ($targetValues as $code => $value) {
                    $criterion = $criteria->get($code);
                    if (! $criterion) {
                        continue;
                    }

                    ExtracurricularCriterionMapping::updateOrCreate(
                        [
                            'extracurricular_id' => $ekskul->id,
                            'criterion_id' => $criterion->id,
                        ],
                        [
                            'value' => $value,
                            'status' => 'validated',
                            'notes' => 'Konfigurasi target desain/riset (Research Baseline - SMKN 3 Payakumbuh)',
                        ]
                    );

                    $createdCount++;
                }
            }

            return $createdCount;
        });
    }

    /**
     * Petakan pertanyaan kuesioner ke kriteria yang sesuai.
     * Item textarea kualitatif atau yang tidak selaras dibiarkan tidak terpetakan.
     *
     * @param array<string, Criterion> $criteria
     */
    public function mapQuestionsToCriteria(array $criteria): void
    {
        $c1 = $criteria['C1'] ?? Criterion::where('code', 'C1')->first();
        $c2 = $criteria['C2'] ?? Criterion::where('code', 'C2')->first();
        $c3 = $criteria['C3'] ?? Criterion::where('code', 'C3')->first();
        $c4 = $criteria['C4'] ?? Criterion::where('code', 'C4')->first();
        $c5 = $criteria['C5'] ?? Criterion::where('code', 'C5')->first();

        // C1 - Minat
        if ($c1) {
            Question::where('category', 'Ketertarikan')->update(['criterion_id' => $c1->id]);
        }

        // C2 - Kemampuan
        if ($c2) {
            Question::where('category', 'Kemampuan')->update(['criterion_id' => $c2->id]);
        }

        // C3 - Karakteristik Diri
        if ($c3) {
            Question::where('category', 'Karakteristik')->update(['criterion_id' => $c3->id]);
        }

        // C4 - Pengalaman (except textarea left unmapped or mapped specifically)
        if ($c4) {
            Question::where('category', 'Pengalaman')
                ->where('type', '!=', 'textarea')
                ->update(['criterion_id' => $c4->id]);
        }

        // C5 - Preferensi Aktivitas (Minat Awal)
        if ($c5) {
            Question::where('category', 'Minat Awal')->update(['criterion_id' => $c5->id]);
        }
    }

    /**
     * Petakan opsi pertanyaan ke CriterionValue yang sesuai.
     * Menghindari pemberian skor sembarangan untuk textarea atau checkbox.
     *
     * @param array<string, Criterion> $criteria
     */
    public function mapQuestionOptionsToCriterionValues(array $criteria): void
    {
        // Load all active questions with criterion
        $questions = Question::whereNotNull('criterion_id')
            ->whereIn('type', ['radio', 'likert'])
            ->with(['criterion.values', 'options'])
            ->get();

        foreach ($questions as $q) {
            if (! $q->criterion) {
                continue;
            }

            $criterionValues = $q->criterion->values->keyBy(fn ($item) => (int) $item->value);

            foreach ($q->options as $opt) {
                if ($opt->value !== null) {
                    $intVal = (int) round($opt->value);
                    if ($criterionValues->has($intVal)) {
                        $opt->update([
                            'criterion_value_id' => $criterionValues->get($intVal)->id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Periksa kelengkapan konfigurasi untuk Phase 4.
     * Menentukan apakah konfigurasi sudah siap untuk SAW (Phase 5).
     *
     * Catatan: READY_FOR_SAW != SAW BERJALAN.
     */
    public function checkCompleteness(): array
    {
        $criteria = Criterion::where('is_active', true)->with('values')->get();
        $totalWeight = (float) $criteria->sum('weight');
        $isWeightValid = abs($totalWeight - 1.00) < 0.001;

        $hasAllProposedCodes = $criteria->pluck('code')->intersect(['C1', 'C2', 'C3', 'C4', 'C5'])->count() === 5;

        // Check criterion values
        $criteriaWithoutValues = $criteria->filter(fn ($c) => $c->values->count() < 5);

        // Check questions mapping (scorable questions only; qualitative textarea is excluded)
        $totalActiveQuestions = Question::where('is_active', true)->where('type', '!=', 'textarea')->count();
        $mappedQuestionsCount = Question::where('is_active', true)->where('type', '!=', 'textarea')->whereNotNull('criterion_id')->count();
        $unmappedQuestionsCount = max(0, $totalActiveQuestions - $mappedQuestionsCount);

        // Check extracurricular mappings
        $totalActiveEkskuls = Extracurricular::where('is_active', true)->count();
        $validatedMappingsCount = ExtracurricularCriterionMapping::where('status', 'validated')->count();
        $expectedMappings = $totalActiveEkskuls * 5;

        $issues = [];

        if (! $hasAllProposedCodes) {
            $issues[] = 'Kriteria belum lengkap (diperlukan 5 kriteria: C1 s/d C5).';
        }

        if (! $isWeightValid) {
            $currentPercent = round($totalWeight * 100, 2);
            $issues[] = "Total bobot kriteria saat ini {$currentPercent}%, belum tepat 100% (1.00).";
        }

        if ($criteriaWithoutValues->isNotEmpty()) {
            $missingNames = $criteriaWithoutValues->pluck('code')->implode(', ');
            $issues[] = "Indikator nilai (skala 1-5) belum lengkap pada kriteria: {$missingNames}.";
        }

        if ($unmappedQuestionsCount > 0) {
            $issues[] = "Terdapat {$unmappedQuestionsCount} pertanyaan aktif yang belum terpetakan ke kriteria.";
        }

        // Extracurricular mapping check
        if ($totalActiveEkskuls === 0) {
            $issues[] = 'Belum ada data ekstrakurikuler aktif yang terdaftar di sistem.';
        } elseif ($validatedMappingsCount < $expectedMappings) {
            $issues[] = 'Matriks nilai ideal ekstrakurikuler belum divalidasi resmi oleh pihak sekolah (Status: NEEDS_VALIDATION). Nilai tidak dikarang bebas demi integritas penelitian.';
        }

        // Status is NOT_READY if there are blocking issues
        $status = empty($issues) ? 'READY_FOR_SAW' : 'NOT_READY';
        $mappingStatus = ($expectedMappings > 0 && $validatedMappingsCount >= $expectedMappings)
            ? 'CONFIGURED_RESEARCH'
            : 'NEEDS_VALIDATION';

        return [
            'status' => $status,
            'status_label' => $status === 'READY_FOR_SAW' ? 'Ready for SAW (Konfigurasi Lengkap)' : 'Not Ready (Menunggu Validasi)',
            'criteria_count' => $criteria->count(),
            'total_weight' => $totalWeight,
            'total_weight_percentage' => round($totalWeight * 100, 2),
            'is_weight_valid' => $isWeightValid,
            'mapped_questions_count' => $mappedQuestionsCount,
            'unmapped_questions_count' => $unmappedQuestionsCount,
            'total_active_questions' => Question::where('is_active', true)->count(),
            'total_active_ekskuls' => $totalActiveEkskuls,
            'extracurricular_mappings_count' => ExtracurricularCriterionMapping::count(),
            'extracurricular_mapping_status' => $mappingStatus,
            'issues' => $issues,
        ];
    }
}
