<?php

namespace Tests\Feature\Services;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Recommendation;
use App\Models\Student;
use App\Models\User;
use App\Services\KalkulatorKecocokan;
use App\Services\KonfigurasiKriteriaService;
use App\Services\MatriksKeputusanService;
use App\Services\RekomendasiSawService;
use App\Services\ProfilKriteriaSiswaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SawRecommendationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RekomendasiSawService $sawService;
    protected Student $student;
    protected Period $period;
    protected array $criteria = [];
    protected array $ekskuls = [];

    protected function setUp(): void
    {
        parent::setUp();

        $profileService = new ProfilKriteriaSiswaService();
        $calc = new KalkulatorKecocokan();
        $matrixService = new MatriksKeputusanService($profileService, $calc);
        $configService = new KonfigurasiKriteriaService();

        $this->sawService = new RekomendasiSawService($matrixService, $configService);

        $user = User::factory()->create(['name' => 'Siswa Saw Test', 'role' => 'student']);
        $this->student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026555',
            'class_name' => 'KULINER 1',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'is_active' => true,
        ]);

        $codes = ['C1', 'C2', 'C3', 'C4', 'C5'];
        $weights = [0.30, 0.25, 0.20, 0.15, 0.10];
        $names = ['Minat', 'Kemampuan', 'Karakteristik Diri', 'Pengalaman', 'Preferensi Aktivitas'];

        foreach ($codes as $i => $code) {
            $this->criteria[$code] = Criterion::create([
                'code' => $code,
                'name' => $names[$i],
                'type' => 'benefit',
                'weight' => $weights[$i],
                'is_active' => true,
            ]);
        }

        $this->ekskuls['paskibraka'] = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $this->ekskuls['pramuka'] = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $this->ekskuls['marching'] = Extracurricular::create([
            'name' => 'MARCHING BAND',
            'slug' => 'marching-band',
            'category' => 'Seni & Budaya',
            'is_active' => true,
        ]);
    }

    /**
     * Test 1 — Benefit normalization: input [0.25, 0.50, 1.00] with max = 1.00 -> [0.25, 0.50, 1.00]
     */
    public function test_1_benefit_normalization_with_max_one(): void
    {
        $matrixX = [
            1 => ['C1' => 0.25],
            2 => ['C1' => 0.50],
            3 => ['C1' => 1.00],
        ];

        $criteria = ['C1' => ['type' => 'benefit']];

        $matrixR = $this->sawService->normalizeMatrix($matrixX, $criteria);

        $this->assertEquals(0.25, $matrixR[1]['C1']);
        $this->assertEquals(0.50, $matrixR[2]['C1']);
        $this->assertEquals(1.00, $matrixR[3]['C1']);
    }

    /**
     * Test 2 — Benefit normalization with max != 1: input [0.20, 0.40, 0.80] with max = 0.80 -> [0.25, 0.50, 1.00]
     */
    public function test_2_benefit_normalization_with_max_other_than_one(): void
    {
        $matrixX = [
            1 => ['C1' => 0.20],
            2 => ['C1' => 0.40],
            3 => ['C1' => 0.80],
        ];

        $criteria = ['C1' => ['type' => 'benefit']];

        $matrixR = $this->sawService->normalizeMatrix($matrixX, $criteria);

        // 0.20 / 0.80 = 0.25, 0.40 / 0.80 = 0.50, 0.80 / 0.80 = 1.00
        $this->assertEquals(0.25, $matrixR[1]['C1']);
        $this->assertEquals(0.50, $matrixR[2]['C1']);
        $this->assertEquals(1.00, $matrixR[3]['C1']);
    }

    /**
     * Test 3 — Weighted value: normalized = 0.80, weight = 0.30 -> 0.24
     */
    public function test_3_weighted_value_calculation(): void
    {
        $matrixR = [
            1 => ['C1' => 0.80],
        ];

        $criteria = ['C1' => ['weight' => 0.30]];

        $matrixV = $this->sawService->calculateWeightedMatrix($matrixR, $criteria);

        $this->assertEquals(0.24, $matrixV[1]['C1']);
    }

    /**
     * Test 4 — Preference score:
     * C1 = 1.00 * 0.30 = 0.30
     * C2 = 0.80 * 0.25 = 0.20
     * C3 = 0.75 * 0.20 = 0.15
     * C4 = 0.60 * 0.15 = 0.09
     * C5 = 0.50 * 0.10 = 0.05
     * Total = 0.79
     */
    public function test_4_preference_score_calculation(): void
    {
        $matrixV = [
            1 => [
                'C1' => 0.30,
                'C2' => 0.20,
                'C3' => 0.15,
                'C4' => 0.09,
                'C5' => 0.05,
            ],
        ];

        $scores = $this->sawService->calculatePreferenceScores($matrixV);

        $this->assertEquals(0.79, $scores[1]);
    }

    /**
     * Test 5 — Ranking:
     * A = 0.79, B = 0.65, C = 0.90 -> 1 = C, 2 = A, 3 = B
     */
    public function test_5_ranking_sorts_descending(): void
    {
        $alternatives = [
            ['extracurricular_id' => 1, 'name' => 'A', 'slug' => 'a', 'category' => 'Kat A'],
            ['extracurricular_id' => 2, 'name' => 'B', 'slug' => 'b', 'category' => 'Kat B'],
            ['extracurricular_id' => 3, 'name' => 'C', 'slug' => 'c', 'category' => 'Kat C'],
        ];

        $preferenceScores = [
            1 => 0.79,
            2 => 0.65,
            3 => 0.90,
        ];

        $ranking = $this->sawService->rankAlternatives($alternatives, $preferenceScores);

        $this->assertCount(3, $ranking);
        $this->assertEquals(1, $ranking[0]['rank']);
        $this->assertEquals('C', $ranking[0]['name']);
        $this->assertEquals(0.90, $ranking[0]['preference_score']);

        $this->assertEquals(2, $ranking[1]['rank']);
        $this->assertEquals('A', $ranking[1]['name']);
        $this->assertEquals(0.79, $ranking[1]['preference_score']);

        $this->assertEquals(3, $ranking[2]['rank']);
        $this->assertEquals('B', $ranking[2]['name']);
        $this->assertEquals(0.65, $ranking[2]['preference_score']);
    }

    /**
     * Test 6 — Equal scores: A = 0.80, B = 0.80 has deterministic tie-break by ID
     */
    public function test_6_equal_scores_have_deterministic_tie_break(): void
    {
        $alternatives = [
            ['extracurricular_id' => 10, 'name' => 'Ekskul B', 'slug' => 'b', 'category' => 'Kat B'],
            ['extracurricular_id' => 5, 'name' => 'Ekskul A', 'slug' => 'a', 'category' => 'Kat A'],
        ];

        $preferenceScores = [
            10 => 0.80,
            5 => 0.80,
        ];

        $ranking = $this->sawService->rankAlternatives($alternatives, $preferenceScores);

        // Lower ID (5) ranks first deterministically
        $this->assertEquals(5, $ranking[0]['extracurricular_id']);
        $this->assertEquals(1, $ranking[0]['rank']);

        $this->assertEquals(10, $ranking[1]['extracurricular_id']);
        $this->assertEquals(2, $ranking[1]['rank']);
    }

    /**
     * Test 7 — NOT_READY: if target is null or unvalidated, status = NOT_READY and ranking = []
     */
    public function test_7_unvalidated_targets_result_in_not_ready_status_and_empty_ranking(): void
    {
        // Student answers questionnaire
        $this->seedCompleteStudentAnswers();

        // But no validated target mappings exist in DB
        $result = $this->sawService->recommend($this->student, $this->period, persist: false);

        $this->assertEquals('NOT_READY', $result['status']);
        $this->assertEmpty($result['ranking']);
        $this->assertNotEmpty($result['reasons']);
        $this->assertFalse($result['persisted']);
    }

    /**
     * Test 8 — Missing student score: if student has no answers for C3 -> NOT_READY
     */
    public function test_8_missing_student_score_results_in_not_ready(): void
    {
        // Don't seed any answers for student
        $result = $this->sawService->recommend($this->student, $this->period, persist: false);

        $this->assertEquals('NOT_READY', $result['status']);
        $this->assertEmpty($result['ranking']);
    }

    /**
     * Test 9 — Total weight verification: if total weight != 1.00 -> NOT_READY
     */
    public function test_9_invalid_total_weight_fails_readiness_validation(): void
    {
        $matrixData = [
            'status' => 'READY_FOR_SAW',
            'criteria' => [
                'C1' => ['weight' => 0.30],
                'C2' => ['weight' => 0.25],
                // Missing C3, C4, C5 (total weight = 0.55)
            ],
            'alternatives' => [
                ['extracurricular_id' => 1],
            ],
            'matrix_x' => [
                1 => ['C1' => 0.8, 'C2' => 0.7],
            ],
            'reasons' => [],
        ];

        $validation = $this->sawService->validateReadiness($matrixData);

        $this->assertFalse($validation['is_ready']);
        $this->assertTrue(collect($validation['reasons'])->some(fn ($r) => str_contains($r, 'Total bobot')));
    }

    /**
     * Test 10 — Cost normalization future-proofing:
     * Cost formula: min_i(xij) / xij.
     * Input: [2.0, 4.0, 8.0] with min = 2.0 -> [1.00, 0.50, 0.25]
     */
    public function test_10_cost_normalization_formula(): void
    {
        $matrixX = [
            1 => ['C1' => 2.0],
            2 => ['C1' => 4.0],
            3 => ['C1' => 8.0],
        ];

        $criteria = ['C1' => ['type' => 'cost']];

        $matrixR = $this->sawService->normalizeMatrix($matrixX, $criteria);

        // 2/2 = 1.00, 2/4 = 0.50, 2/8 = 0.25
        $this->assertEquals(1.00, $matrixR[1]['C1']);
        $this->assertEquals(0.50, $matrixR[2]['C1']);
        $this->assertEquals(0.25, $matrixR[3]['C1']);
    }

    /**
     * Test End-to-End SAW Execution & Persistence when all prerequisites are READY
     */
    public function test_e2e_saw_recommendation_and_persistence_when_ready(): void
    {
        $this->seedCompleteStudentAnswers();
        $this->seedCompleteValidatedMappings();

        $result = $this->sawService->recommend($this->student, $this->period, persist: true);

        $this->assertEquals('READY', $result['status']);
        $this->assertCount(3, $result['ranking']);
        $this->assertTrue($result['persisted']);
        $this->assertNotNull($result['recommendation_id']);

        // Check persistence in database
        $rec = Recommendation::with('items')->find($result['recommendation_id']);
        $this->assertNotNull($rec);
        $this->assertEquals('SAW', $rec->method_name);
        $this->assertEquals($this->student->id, $rec->student_id);
        $this->assertEquals($this->period->id, $rec->period_id);
        $this->assertCount(3, $rec->items);

        // Idempotency check: running recommend() a second time updates rather than duplicates
        $secondResult = $this->sawService->recommend($this->student, $this->period, persist: true);
        $this->assertEquals($result['recommendation_id'], $secondResult['recommendation_id']);
        $this->assertEquals(1, Recommendation::where('student_id', $this->student->id)->count());
        $this->assertEquals(3, $rec->fresh()->items()->count());
    }

    /**
     * Helper to seed valid answers for all 5 criteria
     */
    protected function seedCompleteStudentAnswers(): void
    {
        foreach ($this->criteria as $code => $crit) {
            $q = Question::create([
                'question' => "Pertanyaan {$code}",
                'category' => 'Testing',
                'type' => 'radio',
                'criterion_id' => $crit->id,
                'is_active' => true,
            ]);

            $opt = QuestionOption::create([
                'question_id' => $q->id,
                'label' => 'Opsi 5',
                'value' => 5.0,
                'sort_order' => 1,
            ]);

            QuestionnaireAnswer::create([
                'student_id' => $this->student->id,
                'period_id' => $this->period->id,
                'question_id' => $q->id,
                'question_option_id' => $opt->id,
                'answer_value' => 5.0,
            ]);
        }
    }

    /**
     * Helper to seed validated mappings for all 3 ekskuls and 5 criteria
     */
    protected function seedCompleteValidatedMappings(): void
    {
        // Target values: Paskibraka has highest compatibility
        $targets = [
            'paskibraka' => ['C1' => 5.0, 'C2' => 5.0, 'C3' => 5.0, 'C4' => 5.0, 'C5' => 5.0], // diff 0 -> comp 1.00
            'pramuka'    => ['C1' => 4.0, 'C2' => 4.0, 'C3' => 4.0, 'C4' => 4.0, 'C5' => 4.0], // diff 1 -> comp 0.75
            'marching'   => ['C1' => 3.0, 'C2' => 3.0, 'C3' => 3.0, 'C4' => 3.0, 'C5' => 3.0], // diff 2 -> comp 0.50
        ];

        foreach ($targets as $slug => $critTargets) {
            $ekskul = $this->ekskuls[$slug];
            foreach ($critTargets as $critCode => $targetVal) {
                ExtracurricularCriterionMapping::create([
                    'extracurricular_id' => $ekskul->id,
                    'criterion_id' => $this->criteria[$critCode]->id,
                    'value' => $targetVal,
                    'status' => 'validated',
                ]);
            }
        }
    }
}
