<?php

namespace Tests\Feature\Student;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRecommendationTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;
    protected Student $student;
    protected Period $period;
    protected Extracurricular $ekskul;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentUser = User::factory()->create(['name' => 'Budi Siswa', 'role' => 'student']);
        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'nis' => '2026123',
            'class_name' => 'KULINER 1',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'is_active' => true,
        ]);

        $this->ekskul = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_recommendations(): void
    {
        $response = $this->get('/siswa/rekomendasi');
        $response->assertRedirect('/login');

        $response = $this->get('/siswa/rekomendasi/' . $this->ekskul->id);
        $response->assertRedirect('/login');
    }

    public function test_student_can_view_recommendations_index_page(): void
    {
        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi');
        $response->assertOk();
        $response->assertViewIs('siswa.rekomendasi.index');
        $response->assertSee('Rekomendasi Untukmu');
    }

    public function test_student_sees_not_ready_notice_when_configuration_is_unvalidated(): void
    {
        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi');
        $response->assertOk();
        $response->assertSee('Rekomendasi Belum Dapat Dihitung');
        $response->assertSee('Lengkapi Kuesioner Sekarang');
    }

    public function test_student_sees_calculated_rankings_when_data_is_ready(): void
    {
        // Setup 5 criteria and validated data
        $codes = ['C1', 'C2', 'C3', 'C4', 'C5'];
        $weights = [0.30, 0.25, 0.20, 0.15, 0.10];

        foreach ($codes as $i => $code) {
            $crit = Criterion::create([
                'code' => $code,
                'name' => "Kriteria {$code}",
                'type' => 'benefit',
                'weight' => $weights[$i],
                'is_active' => true,
            ]);

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

            ExtracurricularCriterionMapping::create([
                'extracurricular_id' => $this->ekskul->id,
                'criterion_id' => $crit->id,
                'value' => 5.0,
                'status' => 'validated',
            ]);
        }

        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi');
        $response->assertOk();
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('Pilihan Paling Sesuai');
        $response->assertSee('#1');
    }

    public function test_student_can_view_recommendation_detail_page(): void
    {
        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi/' . $this->ekskul->id);
        $response->assertOk();
        $response->assertViewIs('siswa.rekomendasi.show');
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('Detail Analisis Kesesuaian');
    }

    public function test_inactive_extracurricular_returns_404_on_recommendation_detail_page(): void
    {
        $inactiveEkskul = Extracurricular::create([
            'name' => 'EKSKUL NONAKTIF',
            'slug' => 'ekskul-nonaktif',
            'category' => 'Umum',
            'is_active' => false,
        ]);

        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi/' . $inactiveEkskul->id);
        $response->assertNotFound();
    }

    public function test_uncalculated_recommendation_detail_page_does_not_display_fallback_85_score(): void
    {
        $this->actingAs($this->studentUser);

        $response = $this->get('/siswa/rekomendasi/' . $this->ekskul->id);
        $response->assertOk();
        $response->assertSee('Belum Dihitung');
        $response->assertDontSee('85 / 100');
        $response->assertDontSee('85</span>');
    }
}
