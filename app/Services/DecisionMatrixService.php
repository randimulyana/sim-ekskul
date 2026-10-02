<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Period;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;

class DecisionMatrixService
{
    public function __construct(
        protected StudentCriterionProfileService $profileService,
        protected CompatibilityCalculator $compatibilityCalculator
    ) {}

    /**
     * Build the Decision Matrix X for a student in a period.
     *
     * In Decision Matrix X:
     * - Rows (Alternatives): Active Extracurriculars
     * - Columns (Criteria): Active Criteria (C1 - C5)
     * - Cells (x_ij): Compatibility score of student on criterion j for alternative i
     *
     * IMPORTANT METHODOLOGICAL RULES:
     * - NO SAW normalization performed here.
     * - NO weighted multiplication performed here.
     * - NO ranking or sorting by score performed here.
     * - If target values or mappings are unvalidated, status is NOT_READY.
     * - Missing targets are NEVER assumed as 0 or 3.
     *
     * @return array{
     *     status: string,
     *     status_label: string,
     *     student: array{id: int, name: string, nis: string, class: ?string},
     *     period: ?array{id: ?int, name: ?string, academic_year: ?string, is_active: bool},
     *     criteria: array<string, array{id: int, code: string, name: string, type: string, weight: float, student_score: ?float}>,
     *     alternatives: array<int, array{
     *         extracurricular_id: int,
     *         name: string,
     *         slug: string,
     *         category: string,
     *         criteria: array<string, array{
     *             criterion_code: string,
     *             student_score: ?float,
     *             target_score: ?float,
     *             compatibility: ?float,
     *             status: string,
     *             status_label: string
     *         }>,
     *         status: string
     *     }>,
     *     matrix_x: array<int, array<string, ?float>>,
     *     completeness: array{
     *         total_alternatives: int,
     *         total_criteria: int,
     *         expected_cells: int,
     *         ready_cells_count: int,
     *         needs_validation_cells_count: int,
     *         is_matrix_complete: bool
     *     },
     *     reasons: array<string>,
     *     saw_status: array<string, string>
     * }
     */
    public function build(Student $student, ?Period $period = null): array
    {
        $period = $period ?? Period::where('is_active', true)->first();

        // 1. Fetch active criteria ordered by code
        $criteria = Criterion::where('is_active', true)
            ->orderBy('code')
            ->get();

        // 2. Fetch active extracurriculars ordered by name (inactive are excluded)
        $extracurriculars = Extracurricular::where('is_active', true)
            ->orderBy('name')
            ->get();

        // 3. Get Student Criterion Profile (C1 - C5 scores)
        $studentProfile = $this->profileService->getProfile($student, $period);

        // 4. Fetch all extracurricular mappings
        $mappings = ExtracurricularCriterionMapping::all()
            ->groupBy(fn ($m) => "{$m->extracurricular_id}_{$m->criterion_id}");

        // 5. Build Alternatives and Decision Matrix X
        $alternatives = [];
        $matrixX = [];
        $readyCellsCount = 0;
        $needsValidationCellsCount = 0;

        foreach ($extracurriculars as $ekskul) {
            $altCriteria = [];
            $altMatrixRow = [];
            $hasUnvalidatedCell = false;

            foreach ($criteria as $criterion) {
                $code = $criterion->code;
                $studentScore = $studentProfile['criteria'][$code]['score'] ?? null;

                $mappingKey = "{$ekskul->id}_{$criterion->id}";
                $mapping = $mappings->get($mappingKey)?->first();

                $targetScore = $mapping?->value !== null ? (float) $mapping->value : null;
                $mappingStatus = $mapping?->status ?? 'needs_validation';

                $evaluated = $this->compatibilityCalculator->evaluate(
                    $studentScore,
                    $targetScore,
                    $mappingStatus
                );

                $altCriteria[$code] = [
                    'criterion_code' => $code,
                    'student_score' => $studentScore,
                    'target_score' => $targetScore,
                    'compatibility' => $evaluated['compatibility'],
                    'status' => $evaluated['status'],
                    'status_label' => $evaluated['status_label'],
                ];

                $altMatrixRow[$code] = $evaluated['compatibility'];

                if ($evaluated['status'] === 'READY') {
                    $readyCellsCount++;
                } else {
                    if ($evaluated['status'] === 'NEEDS_VALIDATION') {
                        $needsValidationCellsCount++;
                    }
                    $hasUnvalidatedCell = true;
                }
            }

            $alternatives[] = [
                'extracurricular_id' => $ekskul->id,
                'name' => $ekskul->name,
                'slug' => $ekskul->slug,
                'category' => $ekskul->category,
                'criteria' => $altCriteria,
                'status' => $hasUnvalidatedCell ? 'NEEDS_VALIDATION' : 'READY',
            ];

            $matrixX[$ekskul->id] = $altMatrixRow;
        }

        // 6. Criteria summary
        $criteriaSummary = [];
        foreach ($criteria as $c) {
            $criteriaSummary[$c->code] = [
                'id' => $c->id,
                'code' => $c->code,
                'name' => $c->name,
                'type' => $c->type,
                'weight' => (float) $c->weight,
                'student_score' => $studentProfile['criteria'][$c->code]['score'] ?? null,
            ];
        }

        // 7. Check Readiness & Reasons for NOT_READY status
        $reasons = [];

        if (! $period) {
            $reasons[] = 'Tidak ada periode pendaftaran kuesioner yang aktif.';
        } else {
            $hasAnswers = QuestionnaireAnswer::where('student_id', $student->id)
                ->where('period_id', $period->id)
                ->exists();

            if (! $hasAnswers) {
                $reasons[] = 'Siswa belum mengisi kuesioner pada periode aktif.';
            }
        }

        if (! $studentProfile['is_complete']) {
            $missing = implode(', ', $studentProfile['missing_criteria']);
            $reasons[] = "Profil kriteria siswa belum lengkap (kriteria tanpa nilai: {$missing}).";
        }

        if ($criteria->count() < 5) {
            $reasons[] = 'Jumlah kriteria aktif kurang dari 5 kriteria dasar (C1-C5).';
        }

        if ($extracurriculars->isEmpty()) {
            $reasons[] = 'Belum ada ekstrakurikuler aktif yang terdaftar di sistem.';
        }

        if ($needsValidationCellsCount > 0) {
            $reasons[] = 'Matriks nilai target/ideal ekstrakurikuler belum divalidasi resmi oleh pihak sekolah (Status: NEEDS_VALIDATION). Nilai tidak dikarang bebas demi integritas penelitian.';
        }

        $overallStatus = empty($reasons) ? 'READY_FOR_SAW' : 'NOT_READY';
        $overallStatusLabel = $overallStatus === 'READY_FOR_SAW'
            ? 'Ready for SAW (Matriks Keputusan Lengkap)'
            : 'Not Ready (Menunggu Validasi Resmi)';

        $totalCells = count($alternatives) * count($criteria);

        return [
            'status' => $overallStatus,
            'status_label' => $overallStatusLabel,
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'class' => $student->class_name,
            ],
            'period' => $period ? [
                'id' => $period->id,
                'name' => $period->name,
                'academic_year' => $period->academic_year,
                'is_active' => (bool) $period->is_active,
            ] : null,
            'criteria' => $criteriaSummary,
            'alternatives' => $alternatives,
            'matrix_x' => $matrixX,
            'completeness' => [
                'total_alternatives' => count($alternatives),
                'total_criteria' => count($criteria),
                'expected_cells' => $totalCells,
                'ready_cells_count' => $readyCellsCount,
                'needs_validation_cells_count' => $needsValidationCellsCount,
                'is_matrix_complete' => ($readyCellsCount === $totalCells && $totalCells > 0),
            ],
            'reasons' => $reasons,
            'saw_status' => [
                'normalization' => 'NOT_IMPLEMENTED',
                'weighted_multiplication' => 'NOT_IMPLEMENTED',
                'ranking' => 'NOT_IMPLEMENTED',
                'final_recommendation' => 'NOT_IMPLEMENTED',
            ],
        ];
    }
}
