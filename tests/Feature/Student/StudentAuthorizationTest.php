<?php

namespace Tests\Feature\Student;

use App\Models\Period;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_student_routes(): void
    {
        $this->get('/siswa/dashboard')->assertRedirect('/login');
        $this->get('/siswa/profil')->assertRedirect('/login');
        $this->get('/siswa/ekstrakurikuler')->assertRedirect('/login');
        $this->get('/siswa/kuesioner')->assertRedirect('/login');
        $this->get('/siswa/rekomendasi')->assertRedirect('/login');
        $this->get('/siswa/riwayat')->assertRedirect('/login');
        $this->get('/siswa/pendaftaran')->assertRedirect('/login');
    }

    public function test_student_can_access_student_routes(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $this->actingAs($user);

        $this->get('/siswa/dashboard')->assertOk();
        $this->get('/siswa/profil')->assertOk();
        $this->get('/siswa/ekstrakurikuler')->assertOk();
        $this->get('/siswa/kuesioner')->assertOk();
        $this->get('/siswa/rekomendasi')->assertOk();
        $this->get('/siswa/riwayat')->assertOk();
        $this->get('/siswa/pendaftaran')->assertOk();
    }

    public function test_admin_is_forbidden_from_student_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get('/siswa/dashboard');
        $response->assertForbidden();
        $response->assertDontSee('Halaman ini hanya untuk Administrator');
        $response->assertSee('Akses tidak diizinkan. Anda tidak memiliki hak akses untuk halaman ini.');

        $this->get('/siswa/profil')->assertForbidden();
        $this->get('/siswa/kuesioner')->assertForbidden();
    }

    public function test_student_is_forbidden_from_admin_routes(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);
        $this->actingAs($studentUser);

        $this->get('/admin/dashboard')->assertForbidden();
        $this->get('/admin/siswa')->assertForbidden();
        $this->get('/admin/ekstrakurikuler')->assertForbidden();
        $this->get('/admin/kuesioner')->assertForbidden();
        $this->get('/admin/pengaturan')->assertForbidden();
    }

    public function test_student_cannot_tamper_with_other_student_profile_data(): void
    {
        $studentA = User::factory()->create(['role' => 'student', 'name' => 'Student A']);
        $studentRecordA = Student::create([
            'user_id' => $studentA->id,
            'nis' => '2026101',
            'class_name' => 'KULINER 1',
            'whatsapp' => '08111111111',
            'status' => 'active',
        ]);

        $studentB = User::factory()->create(['role' => 'student', 'name' => 'Student B']);
        $studentRecordB = Student::create([
            'user_id' => $studentB->id,
            'nis' => '2026102',
            'class_name' => 'BUSANA 1',
            'whatsapp' => '08222222222',
            'status' => 'active',
        ]);

        // Student A visits own profile
        $response = $this->actingAs($studentA)->get('/siswa/profil');
        $response->assertOk();
        $response->assertSee('Student A');
        $response->assertSee('2026101');
        $response->assertDontSee('Student B');
        $response->assertDontSee('2026102');
    }
}
