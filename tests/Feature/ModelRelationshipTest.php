<?php

namespace Tests\Feature;

use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Recommendation;
use App\Models\RecommendationItem;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_default_student_role_and_helpers(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->assertEquals('student', $user->role);
        $this->assertTrue($user->isStudent());
        $this->assertFalse($user->isAdmin());

        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isStudent());
    }

    public function test_user_and_student_one_to_one_relationship(): void
    {
        $user = User::create([
            'name' => 'Siti Aulia',
            'email' => 'siti@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026112',
            'class_name' => 'PERHOTELAN 1',
            'whatsapp' => '08776655443',
        ]);

        $this->assertInstanceOf(Student::class, $user->student);
        $this->assertEquals($student->id, $user->student->id);
        $this->assertInstanceOf(User::class, $student->user);
        $this->assertEquals($user->id, $student->user->id);
    }

    public function test_period_and_registration_relationship(): void
    {
        $period = Period::create([
            'name' => 'TP 2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026089',
            'class_name' => 'TKJ',
            'whatsapp' => '08219876543',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $registration = Registration::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'extracurricular_id' => $ekskul->id,
            'registration_number' => 'REG-2026-001',
            'status' => 'submitted',
            'motivation' => 'Ingin belajar kedisiplinan',
            'registered_at' => now(),
        ]);

        // Student relations
        $this->assertCount(1, $student->registrations);
        $this->assertEquals($registration->id, $student->registrations->first()->id);

        // Period relations
        $this->assertCount(1, $period->registrations);
        $this->assertEquals($registration->id, $period->registrations->first()->id);

        // Extracurricular relations
        $this->assertCount(1, $ekskul->registrations);
        $this->assertEquals($registration->id, $ekskul->registrations->first()->id);

        // Inverse relations
        $this->assertEquals($student->id, $registration->student->id);
        $this->assertEquals($period->id, $registration->period->id);
        $this->assertEquals($ekskul->id, $registration->extracurricular->id);
    }

    public function test_criteria_and_criterion_values_relationship(): void
    {
        $criterion = Criterion::create([
            'code' => 'C1',
            'name' => 'Minat Fisik',
            'description' => 'Ketertarikan pada aktivitas gerak fisik',
            'type' => 'benefit',
            'weight' => 0.2500,
            'is_active' => true,
        ]);

        $val1 = CriterionValue::create([
            'criterion_id' => $criterion->id,
            'label' => 'Rendah',
            'value' => 1.0,
            'sort_order' => 1,
        ]);

        $val2 = CriterionValue::create([
            'criterion_id' => $criterion->id,
            'label' => 'Tinggi',
            'value' => 5.0,
            'sort_order' => 2,
        ]);

        $this->assertCount(2, $criterion->values);
        $this->assertEquals($criterion->id, $val1->criterion->id);
        $this->assertEquals($criterion->id, $val2->criterion->id);
    }

    public function test_extracurricular_and_criteria_many_to_many_mapping(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $criterion = Criterion::create([
            'code' => 'C2',
            'name' => 'Kemandirian Alam',
            'type' => 'benefit',
            'weight' => 0.3000,
            'is_active' => true,
        ]);

        $mapping = ExtracurricularCriterionMapping::create([
            'extracurricular_id' => $ekskul->id,
            'criterion_id' => $criterion->id,
            'value' => 4.5,
            'notes' => 'Target nilai kemandirian untuk Pramuka',
        ]);

        $this->assertCount(1, $ekskul->criteria);
        $this->assertEquals($criterion->id, $ekskul->criteria->first()->id);
        $this->assertEquals(4.5, $ekskul->criteria->first()->pivot->value);

        $this->assertCount(1, $criterion->extracurriculars);
        $this->assertEquals($ekskul->id, $criterion->extracurriculars->first()->id);

        $this->assertEquals($ekskul->id, $mapping->extracurricular->id);
        $this->assertEquals($criterion->id, $mapping->criterion->id);
    }

    public function test_question_options_and_answers_relationship(): void
    {
        $criterion = Criterion::create([
            'code' => 'C3',
            'name' => 'Kepemimpinan',
            'type' => 'benefit',
            'is_active' => true,
        ]);

        $question = Question::create([
            'criterion_id' => $criterion->id,
            'question' => 'Seberapa siap kamu memimpin tim dalam regu?',
            'category' => 'Kemampuan',
            'type' => 'single_choice',
            'is_required' => true,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $opt1 = QuestionOption::create([
            'question_id' => $question->id,
            'label' => 'Sangat Siap',
            'value' => 5.0,
            'sort_order' => 1,
        ]);

        $opt2 = QuestionOption::create([
            'question_id' => $question->id,
            'label' => 'Cukup Siap',
            'value' => 3.0,
            'sort_order' => 2,
        ]);

        $this->assertCount(2, $question->options);
        $this->assertEquals($criterion->id, $question->criterion->id);
        $this->assertEquals($question->id, $opt1->question->id);

        $period = Period::create([
            'name' => 'TP 2026/2027',
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Danu Wirawan',
            'email' => 'danu@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026067',
            'class_name' => 'ANIMASI',
        ]);

        $answer = QuestionnaireAnswer::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'question_id' => $question->id,
            'question_option_id' => $opt1->id,
            'answer_value' => 5.0,
        ]);

        $this->assertCount(1, $student->questionnaireAnswers);
        $this->assertCount(1, $period->questionnaireAnswers);
        $this->assertCount(1, $question->answers);
        $this->assertCount(1, $opt1->answers);

        $this->assertEquals($student->id, $answer->student->id);
        $this->assertEquals($period->id, $answer->period->id);
        $this->assertEquals($question->id, $answer->question->id);
        $this->assertEquals($opt1->id, $answer->questionOption->id);
    }

    public function test_recommendation_and_items_relationship(): void
    {
        $period = Period::create([
            'name' => 'TP 2026/2027',
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'Andi Saputra',
            'email' => 'andi@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026001',
            'class_name' => 'KULINER 1',
        ]);

        $ekskul1 = Extracurricular::create(['name' => 'PASKIBRAKA', 'slug' => 'paskibraka', 'is_active' => true]);
        $ekskul2 = Extracurricular::create(['name' => 'PRAMUKA', 'slug' => 'pramuka', 'is_active' => true]);

        $recommendation = Recommendation::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'method_name' => 'SAW',
            'method_version' => '1.0',
            'generated_at' => now(),
        ]);

        $item1 = RecommendationItem::create([
            'recommendation_id' => $recommendation->id,
            'extracurricular_id' => $ekskul1->id,
            'score' => 92.0000,
            'rank' => 1,
            'explanation' => 'Kesesuaian fisik dan disiplin tinggi',
        ]);

        $item2 = RecommendationItem::create([
            'recommendation_id' => $recommendation->id,
            'extracurricular_id' => $ekskul2->id,
            'score' => 87.0000,
            'rank' => 2,
            'explanation' => 'Kesesuaian petualangan alam',
        ]);

        $this->assertCount(1, $student->recommendations);
        $this->assertCount(2, $recommendation->items);
        $this->assertEquals(1, $recommendation->items->first()->rank);
        $this->assertEquals($ekskul1->id, $recommendation->items->first()->extracurricular->id);
        $this->assertEquals($recommendation->id, $item1->recommendation->id);
        $this->assertEquals($ekskul1->id, $item1->extracurricular->id);
    }
}
