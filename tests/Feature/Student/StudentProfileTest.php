<?php

namespace Tests\Feature\Student;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_own_profile_page(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'name' => 'Muhammad Rizki',
            'email' => 'rizki@example.com',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026501',
            'class_name' => 'TKJ',
            'whatsapp' => '081234567890',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get('/siswa/profil');

        $response->assertOk();
        $response->assertSee('Muhammad Rizki');
        $response->assertSee('rizki@example.com');
        $response->assertSee('2026501');
        $response->assertSee('TKJ');
        $response->assertSee('081234567890');
    }

    public function test_student_can_update_name_and_whatsapp(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'name' => 'Nama Lama',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026502',
            'class_name' => 'ANIMASI',
            'whatsapp' => '08111111111',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put('/siswa/profil', [
            'name' => 'Nama Baru Siswa',
            'whatsapp' => '089999999999',
        ]);

        $response->assertRedirect('/siswa/profil');
        $response->assertSessionHas('success');

        $user->refresh();
        $student->refresh();

        $this->assertEquals('Nama Baru Siswa', $user->name);
        $this->assertEquals('089999999999', $student->whatsapp);
    }

    public function test_student_cannot_modify_nis_class_or_role(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'name' => 'Siswa Asli',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026777',
            'class_name' => 'BUSANA 1',
            'whatsapp' => '08123456789',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put('/siswa/profil', [
            'name' => 'Siswa Asli',
            'whatsapp' => '08123456789',
            'nis' => '9999999', // Malicious attempt to change NIS
            'class_name' => 'KULINER 4', // Malicious attempt to change class
            'role' => 'admin', // Malicious attempt to elevate role
        ]);

        $response->assertRedirect('/siswa/profil');

        $user->refresh();
        $student->refresh();

        $this->assertEquals('2026777', $student->nis);
        $this->assertEquals('BUSANA 1', $student->class_name);
        $this->assertEquals('student', $user->role);
    }

    public function test_student_can_change_password_with_valid_current_password(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'password' => Hash::make('old-password-123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026888',
            'class_name' => 'PERHOTELAN 1',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put('/siswa/profil', [
            'name' => $user->name,
            'current_password' => 'old-password-123',
            'password' => 'new-secure-password-456',
            'password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertRedirect('/siswa/profil');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('new-secure-password-456', $user->password));
    }

    public function test_student_cannot_change_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'password' => Hash::make('correct-password-123'),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026889',
            'class_name' => 'PERHOTELAN 2',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put('/siswa/profil', [
            'name' => $user->name,
            'current_password' => 'wrong-current-pass',
            'password' => 'new-password-456',
            'password_confirmation' => 'new-password-456',
        ]);

        $response->assertSessionHasErrors(['current_password']);

        $user->refresh();
        $this->assertTrue(Hash::check('correct-password-123', $user->password));
    }
}
