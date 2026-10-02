<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_admin_routes(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/siswa');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/ekstrakurikuler');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/pendaftaran');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/kuesioner');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/pengaturan');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/profil');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/rekomendasi');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/laporan');
        $response->assertRedirect('/login');
    }

    public function test_student_gets_403_forbidden_when_accessing_admin_routes(): void
    {
        $studentUser = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($studentUser);

        $this->get('/admin/dashboard')->assertForbidden();
        $this->get('/admin/siswa')->assertForbidden();
        $this->get('/admin/ekstrakurikuler')->assertForbidden();
        $this->get('/admin/pendaftaran')->assertForbidden();
        $this->get('/admin/kuesioner')->assertForbidden();
        $this->get('/admin/pengaturan')->assertForbidden();
        $this->get('/admin/profil')->assertForbidden();
        $this->get('/admin/rekomendasi')->assertForbidden();
        $this->get('/admin/laporan')->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard_and_modules(): void
    {
        $adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($adminUser);

        $this->get('/admin/dashboard')->assertOk();
        $this->get('/admin/siswa')->assertOk();
        $this->get('/admin/ekstrakurikuler')->assertOk();
        $this->get('/admin/pendaftaran')->assertOk();
        $this->get('/admin/kuesioner')->assertOk();
        $this->get('/admin/pengaturan')->assertOk();
        $this->get('/admin/profil')->assertOk();
        $this->get('/admin/rekomendasi')->assertOk();
        $this->get('/admin/laporan')->assertOk();
    }

    public function test_student_can_access_student_prototype_routes(): void
    {
        $studentUser = User::factory()->create([
            'role' => 'student',
        ]);

        $this->actingAs($studentUser);

        $this->get('/siswa/dashboard')->assertOk();
        $this->get('/siswa/ekstrakurikuler')->assertOk();
        $this->get('/siswa/kuesioner')->assertOk();
        $this->get('/siswa/rekomendasi')->assertOk();
    }

    public function test_public_registration_defaults_to_student_and_ignores_injected_admin_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Siswa Baru',
            'email' => 'siswa.baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin', // Malicious attempt to register as admin
        ]);

        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'siswa.baru@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('student', $user->role);
        $this->assertFalse($user->isAdmin());
        $this->assertTrue($user->isStudent());
    }
}
