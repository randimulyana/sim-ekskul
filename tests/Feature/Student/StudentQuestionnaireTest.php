<?php

namespace Tests\Feature\Student;

use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentQuestionnaireTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;
    protected Student $student;
    protected Period $activePeriod;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentUser = User::factory()->create(['role' => 'student', 'name' => 'Ahmad Siswa']);
        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'nis' => '2026111',
            'class_name' => 'KULINER 1',
            'whatsapp' => '081234567890',
            'status' => 'active',
        ]);

        $this->activePeriod = Period::create([
            'name' => 'TP 2026/2027',
            'academic_year' => '2026/2027',
            'start_date' => now()->subDay(),
            'end_date' => now()->addMonth(),
            'is_active' => true,
        ]);
    }

    public function test_questionnaire_page_shows_no_period_alert_when_no_active_period(): void
    {
        $this->activePeriod->update(['is_active' => false]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/kuesioner');

        $response->assertOk();
        $response->assertSee('Periode Pendaftaran Sedang Ditutup');
    }

    public function test_questionnaire_page_renders_active_questions_grouped_by_category(): void
    {
        $q1 = Question::create([
            'question' => 'Bagaimana gaya belajarmu?',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        QuestionOption::create([
            'question_id' => $q1->id,
            'label' => 'Kinestetik Praktik',
            'value' => 5,
            'sort_order' => 1,
        ]);

        $q2 = Question::create([
            'question' => 'Seberapa suka kegiatan luar ruangan?',
            'category' => 'Minat Awal',
            'type' => 'likert',
            'sort_order' => 2,
            'is_required' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/kuesioner');

        $response->assertOk();
        $response->assertSee('Bagaimana gaya belajarmu?');
        $response->assertSee('Kinestetik Praktik');
        $response->assertSee('Seberapa suka kegiatan luar ruangan?');
    }

    public function test_student_can_save_answers_for_radio_likert_checkbox_and_textarea(): void
    {
        $qRadio = Question::create([
            'question' => 'Pilihan Utama',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        $optRadio = QuestionOption::create([
            'question_id' => $qRadio->id,
            'label' => 'Opsi A',
            'value' => 5,
            'sort_order' => 1,
        ]);

        $qLikert = Question::create([
            'question' => 'Skala Sikap',
            'category' => 'Karakteristik',
            'type' => 'likert',
            'sort_order' => 2,
            'is_required' => true,
            'is_active' => true,
        ]);
        $optLikert = QuestionOption::create([
            'question_id' => $qLikert->id,
            'label' => '4 - Suka',
            'value' => 4,
            'sort_order' => 1,
        ]);

        $qCheck = Question::create([
            'question' => 'Bidang Diminati',
            'category' => 'Ketertarikan',
            'type' => 'checkbox',
            'sort_order' => 3,
            'is_required' => true,
            'is_active' => true,
        ]);
        $optCheck1 = QuestionOption::create([
            'question_id' => $qCheck->id,
            'label' => 'Olahraga',
            'value' => 5,
            'sort_order' => 1,
        ]);
        $optCheck2 = QuestionOption::create([
            'question_id' => $qCheck->id,
            'label' => 'Seni Musik',
            'value' => 5,
            'sort_order' => 2,
        ]);

        $qText = Question::create([
            'question' => 'Ceritakan Pengalaman',
            'category' => 'Pengalaman',
            'type' => 'textarea',
            'sort_order' => 4,
            'is_required' => false,
            'is_active' => true,
        ]);

        $payload = [
            'is_final' => 0, // Draf save
            'answers' => [
                $qRadio->id => $optRadio->id,
                $qLikert->id => $optLikert->id,
                $qCheck->id => [$optCheck1->id, $optCheck2->id],
                $qText->id => 'Saya pernah aktif paskibra di SMP.',
            ],
        ];

        $response = $this->actingAs($this->studentUser)->post('/siswa/kuesioner', $payload);

        $response->assertRedirect('/siswa/kuesioner');
        $response->assertSessionHas('success');

        // Check single radio answer saved
        $this->assertDatabaseHas('questionnaire_answers', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $qRadio->id,
            'question_option_id' => $optRadio->id,
            'answer_value' => 5,
        ]);

        // Check likert answer saved
        $this->assertDatabaseHas('questionnaire_answers', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $qLikert->id,
            'question_option_id' => $optLikert->id,
            'answer_value' => 4,
        ]);

        // Check checkbox answers saved as separate rows
        $this->assertDatabaseHas('questionnaire_answers', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $qCheck->id,
            'question_option_id' => $optCheck1->id,
        ]);
        $this->assertDatabaseHas('questionnaire_answers', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $qCheck->id,
            'question_option_id' => $optCheck2->id,
        ]);

        // Check textarea answer saved
        $this->assertDatabaseHas('questionnaire_answers', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $qText->id,
            'answer_text' => 'Saya pernah aktif paskibra di SMP.',
        ]);
    }

    public function test_saving_answers_updates_without_duplicates(): void
    {
        $q = Question::create([
            'question' => 'Pilihan Single',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        $optA = QuestionOption::create([
            'question_id' => $q->id,
            'label' => 'Opsi A',
            'value' => 3,
            'sort_order' => 1,
        ]);
        $optB = QuestionOption::create([
            'question_id' => $q->id,
            'label' => 'Opsi B',
            'value' => 5,
            'sort_order' => 2,
        ]);

        // First submission with option A
        $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'is_final' => 0,
            'answers' => [$q->id => $optA->id],
        ]);

        $this->assertEquals(1, QuestionnaireAnswer::where('student_id', $this->student->id)->where('question_id', $q->id)->count());
        $this->assertDatabaseHas('questionnaire_answers', ['question_option_id' => $optA->id]);

        // Second submission with option B
        $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'is_final' => 0,
            'answers' => [$q->id => $optB->id],
        ]);

        // Must still be exactly 1 row, now pointing to option B
        $this->assertEquals(1, QuestionnaireAnswer::where('student_id', $this->student->id)->where('question_id', $q->id)->count());
        $this->assertDatabaseHas('questionnaire_answers', ['question_option_id' => $optB->id]);
        $this->assertDatabaseMissing('questionnaire_answers', ['question_option_id' => $optA->id]);
    }

    public function test_saving_answers_ignores_invalid_options_from_other_questions(): void
    {
        $q1 = Question::create([
            'question' => 'Q1',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt1 = QuestionOption::create(['question_id' => $q1->id, 'label' => 'Opt 1', 'value' => 1, 'sort_order' => 1]);

        $q2 = Question::create([
            'question' => 'Q2',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 2,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt2 = QuestionOption::create(['question_id' => $q2->id, 'label' => 'Opt 2', 'value' => 2, 'sort_order' => 1]);

        // Try submitting opt2 under q1
        $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'is_final' => 0,
            'answers' => [$q1->id => $opt2->id],
        ]);

        // Should not be saved for q1
        $this->assertEquals(0, QuestionnaireAnswer::where('student_id', $this->student->id)->where('question_id', $q1->id)->count());
    }

    public function test_final_submission_validates_required_questions(): void
    {
        $qReq1 = Question::create([
            'question' => 'Pertanyaan Wajib 1',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt1 = QuestionOption::create(['question_id' => $qReq1->id, 'label' => 'A', 'value' => 5, 'sort_order' => 1]);

        $qReq2 = Question::create([
            'question' => 'Pertanyaan Wajib 2',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 2,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt2 = QuestionOption::create(['question_id' => $qReq2->id, 'label' => 'B', 'value' => 5, 'sort_order' => 1]);

        // Submit only qReq1 with is_final = 1
        $response = $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'is_final' => 1,
            'answers' => [$qReq1->id => $opt1->id],
        ]);

        $response->assertRedirect('/siswa/kuesioner');
        $response->assertSessionHas('error');
        $response->assertSessionHasErrors([$qReq2->id]);

        // Now submit both required questions
        $responseValid = $this->actingAs($this->studentUser)->post('/siswa/kuesioner', [
            'is_final' => 1,
            'answers' => [
                $qReq1->id => $opt1->id,
                $qReq2->id => $opt2->id,
            ],
        ]);

        $responseValid->assertRedirect('/siswa/kuesioner/analisis');
        $responseValid->assertSessionHas('success');
    }

    public function test_questionnaire_progress_calculation(): void
    {
        $q1 = Question::create([
            'question' => 'Q1',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 1,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt1 = QuestionOption::create(['question_id' => $q1->id, 'label' => 'Opt 1', 'value' => 1, 'sort_order' => 1]);

        $q2 = Question::create([
            'question' => 'Q2',
            'category' => 'Minat Awal',
            'type' => 'radio',
            'sort_order' => 2,
            'is_required' => true,
            'is_active' => true,
        ]);
        $opt2 = QuestionOption::create(['question_id' => $q2->id, 'label' => 'Opt 2', 'value' => 2, 'sort_order' => 1]);

        // Initial progress: 0/2
        $p0 = $this->student->getQuestionnaireProgress($this->activePeriod);
        $this->assertEquals(0, $p0['percentage']);
        $this->assertFalse($p0['is_complete']);

        // Answer 1 question: 1/2 (50%)
        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $q1->id,
            'question_option_id' => $opt1->id,
            'answer_value' => 1,
        ]);

        $p1 = $this->student->getQuestionnaireProgress($this->activePeriod);
        $this->assertEquals(1, $p1['answered_questions']);
        $this->assertEquals(50, $p1['percentage']);
        $this->assertFalse($p1['is_complete']);

        // Answer second question: 2/2 (100%)
        QuestionnaireAnswer::create([
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'question_id' => $q2->id,
            'question_option_id' => $opt2->id,
            'answer_value' => 2,
        ]);

        $p2 = $this->student->getQuestionnaireProgress($this->activePeriod);
        $this->assertEquals(2, $p2['answered_questions']);
        $this->assertEquals(100, $p2['percentage']);
        $this->assertTrue($p2['is_complete']);
    }

    public function test_hasil_page_renders_with_progress_and_disclaimer(): void
    {
        $response = $this->actingAs($this->studentUser)->get('/siswa/kuesioner/hasil');

        $response->assertOk();
        $response->assertSee('Hasil Rekomendasi Ekstrakurikuler');
        $response->assertSee('Skor Kecocokan');
        $response->assertSee('Phase 5');
    }
}
