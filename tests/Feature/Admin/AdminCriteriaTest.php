<?php

namespace Tests\Feature\Admin;

use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Extracurricular;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use App\Services\KonfigurasiKriteriaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCriteriaTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->student = User::factory()->create(['role' => 'student']);

        // Seed initial Phase 4 configuration
        app(KonfigurasiKriteriaService::class)->setupProposedConfiguration();
    }

    public function test_guest_is_redirected_from_criteria_routes(): void
    {
        $this->get('/admin/kriteria')->assertRedirect('/login');
        $this->get('/admin/kriteria/create')->assertRedirect('/login');
        $this->post('/admin/kriteria', [])->assertRedirect('/login');
        $this->get('/admin/kriteria/mapping')->assertRedirect('/login');
    }

    public function test_student_is_forbidden_from_criteria_routes(): void
    {
        $this->actingAs($this->student);

        $this->get('/admin/kriteria')->assertForbidden();
        $this->get('/admin/kriteria/create')->assertForbidden();
        $this->post('/admin/kriteria', [
            'code' => 'C99',
            'name' => 'Hack Criterion',
            'type' => 'benefit',
            'weight' => 0.1,
        ])->assertForbidden();
        $this->get('/admin/kriteria/mapping')->assertForbidden();
    }

    public function test_admin_can_view_criteria_index_with_proposed_criteria(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/kriteria');

        $response->assertOk();
        $response->assertSee('C1');
        $response->assertSee('Minat');
        $response->assertSee('30%');

        $response->assertSee('C2');
        $response->assertSee('Kemampuan');
        $response->assertSee('25%');

        $response->assertSee('C3');
        $response->assertSee('Karakteristik Diri');
        $response->assertSee('20%');

        $response->assertSee('C4');
        $response->assertSee('Pengalaman');
        $response->assertSee('15%');

        $response->assertSee('C5');
        $response->assertSee('Preferensi Aktivitas');
        $response->assertSee('10%');

        $response->assertSee('Proposed / Needs Validation');
    }

    public function test_total_weight_of_proposed_criteria_equals_100_percent(): void
    {
        $c1 = Criterion::where('code', 'C1')->first();
        $c2 = Criterion::where('code', 'C2')->first();
        $c3 = Criterion::where('code', 'C3')->first();
        $c4 = Criterion::where('code', 'C4')->first();
        $c5 = Criterion::where('code', 'C5')->first();

        $this->assertNotNull($c1);
        $this->assertNotNull($c2);
        $this->assertNotNull($c3);
        $this->assertNotNull($c4);
        $this->assertNotNull($c5);

        $this->assertEquals(0.30, $c1->weight);
        $this->assertEquals(0.25, $c2->weight);
        $this->assertEquals(0.20, $c3->weight);
        $this->assertEquals(0.15, $c4->weight);
        $this->assertEquals(0.10, $c5->weight);

        $totalWeight = Criterion::getTotalWeight();
        $this->assertEquals(1.00, $totalWeight);
        $this->assertTrue(Criterion::isTotalWeightValid());
    }

    public function test_admin_can_create_new_criterion_with_auto_provisioned_scale_values(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kriteria', [
            'code' => 'C6',
            'name' => 'Kedisiplinan Waktu',
            'type' => 'benefit',
            'weight' => '0.05',
            'description' => 'Ketepatan dan ketaatan jam kehadiran latihan',
        ]);

        $response->assertRedirect('/admin/kriteria');
        $response->assertSessionHas('success');

        $criterion = Criterion::where('code', 'C6')->first();
        $this->assertNotNull($criterion);
        $this->assertEquals('Kedisiplinan Waktu', $criterion->name);
        $this->assertEquals(0.05, $criterion->weight);
        $this->assertEquals('benefit', $criterion->type);

        // Verify standard 1-5 scale values provisioned
        $this->assertEquals(5, $criterion->values()->count());
        $this->assertDatabaseHas('criterion_values', [
            'criterion_id' => $criterion->id,
            'value' => 5,
            'label' => 'Sangat Tinggi',
        ]);
        $this->assertDatabaseHas('criterion_values', [
            'criterion_id' => $criterion->id,
            'value' => 1,
            'label' => 'Sangat Rendah',
        ]);
    }

    public function test_duplicate_criterion_code_is_rejected(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kriteria', [
            'code' => 'C1', // Duplicate of existing C1
            'name' => 'Minat Duplikat',
            'type' => 'benefit',
            'weight' => 0.10,
        ]);

        $response->assertSessionHasErrors(['code']);
    }

    public function test_invalid_weight_is_rejected(): void
    {
        $responseNegative = $this->actingAs($this->admin)->post('/admin/kriteria', [
            'code' => 'C7',
            'name' => 'Invalid Weight',
            'type' => 'benefit',
            'weight' => -0.5,
        ]);
        $responseNegative->assertSessionHasErrors(['weight']);
    }

    public function test_admin_can_edit_existing_criterion(): void
    {
        $c1 = Criterion::where('code', 'C1')->firstOrFail();

        $response = $this->actingAs($this->admin)->put("/admin/kriteria/{$c1->id}", [
            'code' => 'C1',
            'name' => 'Minat & Antusiasme Siswa',
            'type' => 'benefit',
            'weight' => 0.30,
            'status' => 'validated',
            'description' => 'Tingkat antusiasme terhadap kegiatan ekskul terkait.',
        ]);

        $response->assertRedirect('/admin/kriteria');
        $response->assertSessionHas('success');

        $c1->refresh();
        $this->assertEquals('Minat & Antusiasme Siswa', $c1->name);
        $this->assertEquals('validated', $c1->status);
    }

    public function test_admin_can_view_criterion_details_and_scale_values(): void
    {
        $c1 = Criterion::where('code', 'C1')->firstOrFail();

        $response = $this->actingAs($this->admin)->get("/admin/kriteria/{$c1->id}");

        $response->assertOk();
        $response->assertSee('C1');
        $response->assertSee('Minat');
        $response->assertSee('Sangat Tinggi');
        $response->assertSee('Sangat Rendah');
    }

    public function test_question_can_be_mapped_to_criterion(): void
    {
        $c2 = Criterion::where('code', 'C2')->firstOrFail();

        $q = Question::create([
            'question' => 'Seberapa kuat fisikmu?',
            'category' => 'Kemampuan',
            'type' => 'likert',
            'sort_order' => 99,
            'is_required' => true,
            'is_active' => true,
        ]);

        $this->actingAs($this->admin)->put("/admin/kuesioner/{$q->id}", [
            'question_text' => $q->question,
            'category' => $q->category,
            'type' => $q->type,
            'criterion_id' => $c2->id,
        ]);

        $q->refresh();
        $this->assertEquals($c2->id, $q->criterion_id);
        $this->assertEquals('C2', $q->criterion->code);
    }

    public function test_question_rejects_nonexistent_criterion_id(): void
    {
        $q = Question::create([
            'question' => 'Pertanyaan Baru',
            'category' => 'Umum',
            'type' => 'radio',
            'sort_order' => 100,
            'is_required' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/kuesioner/{$q->id}", [
            'question_text' => $q->question,
            'category' => $q->category,
            'type' => $q->type,
            'criterion_id' => 99999, // Invalid ID
        ]);

        $response->assertSessionHasErrors(['criterion_id']);
    }

    public function test_question_option_can_be_mapped_to_criterion_value(): void
    {
        $c1 = Criterion::where('code', 'C1')->firstOrFail();
        $cv5 = CriterionValue::where('criterion_id', $c1->id)->where('value', 5)->firstOrFail();

        $q = Question::create([
            'criterion_id' => $c1->id,
            'question' => 'Apakah kamu suka organisasi?',
            'category' => 'Ketertarikan',
            'type' => 'radio',
            'sort_order' => 101,
            'is_required' => true,
            'is_active' => true,
        ]);

        $opt = QuestionOption::create([
            'question_id' => $q->id,
            'criterion_value_id' => $cv5->id,
            'label' => 'Sangat Suka',
            'value' => 5,
            'sort_order' => 1,
        ]);

        $this->assertEquals($cv5->id, $opt->criterion_value_id);
        $this->assertEquals('Sangat Tinggi', $opt->criterionValue->label);
    }

    public function test_extracurricular_mapping_matrix_view_displays_observed_ekskuls_and_needs_validation(): void
    {
        Extracurricular::updateOrCreate(
            ['slug' => 'paskibraka'],
            [
                'name' => 'PASKIBRAKA',
                'category' => 'Organisasi',
                'is_active' => true,
            ]
        );

        $response = $this->actingAs($this->admin)->get('/admin/kriteria/mapping');

        $response->assertOk();
        $response->assertSee('Matriks Mapping Kriteria Ekstrakurikuler');
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('Perlu Validasi');
        $response->assertSee('NEEDS_VALIDATION');
        $response->assertSee('TIDAK MENGARANG');
    }

    public function test_configuration_completeness_reports_not_ready_due_to_unvalidated_ekskul_matrix(): void
    {
        Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $service = app(KonfigurasiKriteriaService::class);
        $completeness = $service->checkCompleteness();

        $this->assertEquals('NOT_READY', $completeness['status']);
        $this->assertEquals('NEEDS_VALIDATION', $completeness['extracurricular_mapping_status']);
        $this->assertTrue($completeness['is_weight_valid']);
        $this->assertNotEmpty($completeness['issues']);
    }

    public function test_admin_cannot_delete_core_criteria_c1_through_c5(): void
    {
        $coreCodes = ['C1', 'C2', 'C3', 'C4', 'C5'];

        foreach ($coreCodes as $code) {
            $criterion = Criterion::where('code', $code)->firstOrFail();

            $response = $this->actingAs($this->admin)->delete("/admin/kriteria/{$criterion->id}");

            $response->assertRedirect('/admin/kriteria');
            $response->assertSessionHas('error', "Kriteria inti penelitian ({$code}) tidak dapat dihapus.");
            $this->assertDatabaseHas('criteria', ['id' => $criterion->id, 'code' => $code]);
        }
    }

    public function test_admin_can_delete_non_core_criterion(): void
    {
        $nonCore = Criterion::create([
            'code' => 'C6',
            'name' => 'Kedisiplinan',
            'type' => 'benefit',
            'weight' => 0.05,
            'status' => 'proposed',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/kriteria/{$nonCore->id}");

        $response->assertRedirect('/admin/kriteria');
        $response->assertSessionHas('success', 'Kriteria C6 berhasil dihapus.');
        $this->assertDatabaseMissing('criteria', ['id' => $nonCore->id, 'code' => 'C6']);
    }
}
