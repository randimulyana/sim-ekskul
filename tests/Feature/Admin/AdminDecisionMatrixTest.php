<?php

namespace Tests\Feature\Admin;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDecisionMatrixTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $studentUser;
    protected Student $student;
    protected Period $period;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['name' => 'Admin Utama', 'role' => 'admin']);
        $this->studentUser = User::factory()->create(['name' => 'Andi Saputra', 'role' => 'student']);

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'nis' => '2026111',
            'class_name' => 'KULINER 1',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'is_active' => true,
        ]);

        Criterion::create([
            'code' => 'C1',
            'name' => 'Minat',
            'type' => 'benefit',
            'weight' => 0.30,
            'is_active' => true,
        ]);

        Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_from_decision_matrix_preview(): void
    {
        $response = $this->get('/admin/rekomendasi/matriks-keputusan');
        $response->assertRedirect('/login');
    }

    public function test_student_gets_forbidden_from_decision_matrix_preview(): void
    {
        $this->actingAs($this->studentUser);
        $response = $this->get('/admin/rekomendasi/matriks-keputusan');
        $response->assertForbidden();
    }

    public function test_admin_can_access_decision_matrix_preview(): void
    {
        $this->actingAs($this->adminUser);
        $response = $this->get('/admin/rekomendasi/matriks-keputusan');

        $response->assertOk();
        $response->assertViewIs('admin.rekomendasi.matrix');
        $response->assertSee('Matriks Keputusan');
        $response->assertSee('Engine SAW');
        $response->assertSee('Andi Saputra');
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('NEEDS VALIDATION');
    }

    public function test_admin_can_filter_matrix_by_student_id(): void
    {
        $otherUser = User::factory()->create(['name' => 'Budi Santoso', 'role' => 'student']);
        $otherStudent = Student::create([
            'user_id' => $otherUser->id,
            'nis' => '2026222',
            'class_name' => 'TKJ',
        ]);

        $this->actingAs($this->adminUser);
        $response = $this->get('/admin/rekomendasi/matriks-keputusan?student_id=' . $otherStudent->id);

        $response->assertOk();
        $response->assertSee('Budi Santoso');
    }
}
