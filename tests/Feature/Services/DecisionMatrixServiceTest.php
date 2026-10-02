<?php

namespace Tests\Feature\Services;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;
use App\Services\CompatibilityCalculator;
use App\Services\DecisionMatrixService;
use App\Services\StudentCriterionProfileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DecisionMatrixServiceTest extends TestCase
{
    use RefreshDatabase;

    protected DecisionMatrixService $service;
    protected Student $student;
    protected Period $period;
    protected array $criteria = [];
    protected Extracurricular $activeEkskul1;
    protected Extracurricular $activeEkskul2;
    protected Extracurricular $inactiveEkskul;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DecisionMatrixService(
            new StudentCriterionProfileService(),
            new CompatibilityCalculator()
        );

        $user = User::factory()->create(['role' => 'student']);
        $this->student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026777',
            'name' => 'Siswa Matrix Test',
            'class_name' => 'TKJ',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'is_active' => true,
        ]);

        // Create 5 standard criteria
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

        // Active extracurriculars
        $this->activeEkskul1 = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $this->activeEkskul2 = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        // Inactive extracurricular
        $this->inactiveEkskul = Extracurricular::create([
            'name' => 'EKSKUL NONAKTIF',
            'slug' => 'ekskul-nonaktif',
            'category' => 'Lainnya',
            'is_active' => false,
        ]);
    }

    public function test_active_extracurriculars_included_and_inactive_excluded(): void
    {
        $matrix = $this->service->build($this->student, $this->period);

        $altNames = array_column($matrix['alternatives'], 'name');

        $this->assertContains('PASKIBRAKA', $altNames);
        $this->assertContains('PRAMUKA', $altNames);
        $this->assertNotContains('EKSKUL NONAKTIF', $altNames);
    }

    public function test_all_five_criteria_represented_in_decision_matrix(): void
    {
        $matrix = $this->service->build($this->student, $this->period);

        $this->assertCount(5, $matrix['criteria']);
        $this->assertArrayHasKey('C1', $matrix['criteria']);
        $this->assertArrayHasKey('C2', $matrix['criteria']);
        $this->assertArrayHasKey('C3', $matrix['criteria']);
        $this->assertArrayHasKey('C4', $matrix['criteria']);
        $this->assertArrayHasKey('C5', $matrix['criteria']);

        // Check cells for first alternative
        $firstAlt = $matrix['alternatives'][0];
        $this->assertArrayHasKey('C1', $firstAlt['criteria']);
        $this->assertArrayHasKey('C2', $firstAlt['criteria']);
        $this->assertArrayHasKey('C3', $firstAlt['criteria']);
        $this->assertArrayHasKey('C4', $firstAlt['criteria']);
        $this->assertArrayHasKey('C5', $firstAlt['criteria']);
    }

    public function test_missing_target_does_not_become_zero_or_default(): void
    {
        // Don't create any mappings for PASKIBRAKA on C1
        $matrix = $this->service->build($this->student, $this->period);

        $paskibraka = collect($matrix['alternatives'])->firstWhere('name', 'PASKIBRAKA');
        $c1Cell = $paskibraka['criteria']['C1'];

        $this->assertNull($c1Cell['target_score']);
        $this->assertNull($c1Cell['compatibility']);
        $this->assertTrue($c1Cell['target_score'] !== 0.0);
        $this->assertTrue($c1Cell['target_score'] !== 3.0);
        $this->assertEquals('NEEDS_VALIDATION', $c1Cell['status']);
    }

    public function test_unvalidated_mapping_produces_needs_validation_cell_status(): void
    {
        // Create unvalidated mapping
        ExtracurricularCriterionMapping::create([
            'extracurricular_id' => $this->activeEkskul1->id,
            'criterion_id' => $this->criteria['C1']->id,
            'value' => 4.0,
            'status' => 'needs_validation',
        ]);

        $matrix = $this->service->build($this->student, $this->period);

        $paskibraka = collect($matrix['alternatives'])->firstWhere('name', 'PASKIBRAKA');
        $c1Cell = $paskibraka['criteria']['C1'];

        $this->assertEquals(4.0, $c1Cell['target_score']);
        $this->assertEquals('NEEDS_VALIDATION', $c1Cell['status']);
    }

    public function test_incomplete_configuration_produces_not_ready_status(): void
    {
        $matrix = $this->service->build($this->student, $this->period);

        $this->assertEquals('NOT_READY', $matrix['status']);
        $this->assertNotEmpty($matrix['reasons']);
        $this->assertFalse($matrix['completeness']['is_matrix_complete']);
    }

    public function test_ready_configuration_when_all_targets_validated_and_student_answered(): void
    {
        // 1. Answer all 5 criteria with radio questions
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

            // Map all active ekskuls to this criterion with validated status
            foreach ([$this->activeEkskul1, $this->activeEkskul2] as $ekskul) {
                ExtracurricularCriterionMapping::create([
                    'extracurricular_id' => $ekskul->id,
                    'criterion_id' => $crit->id,
                    'value' => 4.0,
                    'status' => 'validated',
                ]);
            }
        }

        $matrix = $this->service->build($this->student, $this->period);

        $this->assertEquals('READY_FOR_SAW', $matrix['status']);
        $this->assertEmpty($matrix['reasons']);
        $this->assertTrue($matrix['completeness']['is_matrix_complete']);

        // Check compatibility calculation: student = 5, target = 4 -> 0.75
        $paskibraka = collect($matrix['alternatives'])->firstWhere('name', 'PASKIBRAKA');
        $this->assertEquals(0.75, $paskibraka['criteria']['C1']['compatibility']);
        $this->assertEquals('READY', $paskibraka['criteria']['C1']['status']);
    }

    public function test_no_ranking_occurs_and_saw_status_is_explicitly_not_implemented(): void
    {
        $matrix = $this->service->build($this->student, $this->period);

        // Alternatives should NOT be sorted by score or rank
        $this->assertEquals('NOT_IMPLEMENTED', $matrix['saw_status']['normalization']);
        $this->assertEquals('NOT_IMPLEMENTED', $matrix['saw_status']['weighted_multiplication']);
        $this->assertEquals('NOT_IMPLEMENTED', $matrix['saw_status']['ranking']);
        $this->assertEquals('NOT_IMPLEMENTED', $matrix['saw_status']['final_recommendation']);
    }
}
