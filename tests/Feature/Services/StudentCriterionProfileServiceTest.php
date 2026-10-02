<?php

namespace Tests\Feature\Services;

use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentCriterionProfileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCriterionProfileServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StudentCriterionProfileService $service;
    protected Student $student;
    protected Period $period;
    protected Criterion $c1;
    protected Criterion $c2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StudentCriterionProfileService();

        $user = User::factory()->create(['role' => 'student']);
        $this->student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026999',
            'name' => 'Siswa Pengujian',
            'class_name' => 'KULINER 1',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'is_active' => true,
        ]);

        $this->c1 = Criterion::create([
            'code' => 'C1',
            'name' => 'Minat',
            'type' => 'benefit',
            'weight' => 0.30,
            'is_active' => true,
        ]);

        $this->c2 = Criterion::create([
            'code' => 'C2',
            'name' => 'Kemampuan',
            'type' => 'benefit',
            'weight' => 0.25,
            'is_active' => true,
        ]);
    }

    public function test_aggregate_score_correctly_for_single_answer(): void
    {
        $q = Question::create([
            'question' => 'Pertanyaan Minat 1',
            'category' => 'Ketertarikan',
            'type' => 'radio',
            'criterion_id' => $this->c1->id,
            'is_active' => true,
        ]);

        $opt = QuestionOption::create([
            'question_id' => $q->id,
            'label' => 'Sangat Tertarik',
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

        $profile = $this->service->getProfile($this->student, $this->period);

        $this->assertEquals(5.0, $profile['criteria']['C1']['score']);
        $this->assertEquals('5.00', $profile['criteria']['C1']['formatted_score']);
        $this->assertEquals(1, $profile['criteria']['C1']['answers_count']);
        $this->assertEquals('calculated', $profile['criteria']['C1']['status']);
    }

    public function test_average_multiple_answers_under_same_criterion(): void
    {
        $q1 = Question::create([
            'question' => 'Kemampuan 1',
            'category' => 'Kemampuan',
            'type' => 'likert',
            'criterion_id' => $this->c2->id,
            'is_active' => true,
        ]);

        $opt1 = QuestionOption::create([
            'question_id' => $q1->id,
            'label' => '4 - Baik',
            'value' => 4.0,
            'sort_order' => 1,
        ]);

        $q2 = Question::create([
            'question' => 'Kemampuan 2',
            'category' => 'Kemampuan',
            'type' => 'likert',
            'criterion_id' => $this->c2->id,
            'is_active' => true,
        ]);

        $opt2 = QuestionOption::create([
            'question_id' => $q2->id,
            'label' => '5 - Sangat Baik',
            'value' => 5.0,
            'sort_order' => 1,
        ]);

        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->period->id,
            'question_id' => $q1->id,
            'question_option_id' => $opt1->id,
            'answer_value' => 4.0,
        ]);

        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->period->id,
            'question_id' => $q2->id,
            'question_option_id' => $opt2->id,
            'answer_value' => 5.0,
        ]);

        $profile = $this->service->getProfile($this->student, $this->period);

        // (4.0 + 5.0) / 2 = 4.50
        $this->assertEquals(4.50, $profile['criteria']['C2']['score']);
        $this->assertEquals('4.50', $profile['criteria']['C2']['formatted_score']);
        $this->assertEquals(2, $profile['criteria']['C2']['answers_count']);
    }

    public function test_ignore_unmapped_textarea_and_checkbox_answers(): void
    {
        // 1. Textarea question (unmapped / qualitative)
        $qText = Question::create([
            'question' => 'Motivasi',
            'category' => 'Pengalaman',
            'type' => 'textarea',
            'criterion_id' => $this->c1->id, // Even if criterion_id is set
            'is_active' => true,
        ]);

        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->period->id,
            'question_id' => $qText->id,
            'answer_text' => 'Ini jawaban kualitatif',
            'answer_value' => null,
        ]);

        // 2. Checkbox question (excluded from arbitrary scoring)
        $qCheck = Question::create([
            'question' => 'Pilihan Minat',
            'category' => 'Ketertarikan',
            'type' => 'checkbox',
            'criterion_id' => $this->c1->id,
            'is_active' => true,
        ]);

        $optCheck = QuestionOption::create([
            'question_id' => $qCheck->id,
            'label' => 'Seni',
            'value' => 5.0,
            'sort_order' => 1,
        ]);

        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->period->id,
            'question_id' => $qCheck->id,
            'question_option_id' => $optCheck->id,
            'answer_value' => 5.0,
        ]);

        $profile = $this->service->getProfile($this->student, $this->period);

        // Since only textarea and checkbox were answered, C1 has NO quantitative score
        $this->assertNull($profile['criteria']['C1']['score']);
        $this->assertEquals(0, $profile['criteria']['C1']['answers_count']);
        $this->assertEquals('missing', $profile['criteria']['C1']['status']);
    }

    public function test_missing_criterion_returns_null_and_is_not_assumed_as_zero(): void
    {
        $profile = $this->service->getProfile($this->student, $this->period);

        $this->assertNull($profile['criteria']['C1']['score']);
        $this->assertNull($profile['criteria']['C2']['score']);
        $this->assertFalse($profile['is_complete']);
        $this->assertContains('C1', $profile['missing_criteria']);
        $this->assertContains('C2', $profile['missing_criteria']);
    }

    public function test_unauthorized_student_cannot_access_another_students_profile(): void
    {
        $otherStudentUser = User::factory()->create(['role' => 'student']);
        $otherStudent = Student::create([
            'user_id' => $otherStudentUser->id,
            'nis' => '2026888',
            'name' => 'Siswa Lain',
        ]);

        $adminUser = User::factory()->create(['role' => 'admin']);

        // Student accessing own profile
        $this->assertTrue($this->service->canAccess($this->student->user, $this->student));

        // Other student accessing target student profile -> FALSE
        $this->assertFalse($this->service->canAccess($otherStudentUser, $this->student));

        // Admin accessing student profile -> TRUE
        $this->assertTrue($this->service->canAccess($adminUser, $this->student));
    }
}
