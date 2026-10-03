<?php

namespace Tests\Feature;

use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStudentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_student_index(): void
    {
        $studentUser = User::factory()->create(['name' => 'Budi Santoso']);
        Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026101',
            'class_name' => 'KULINER 1',
            'whatsapp' => '081234567890',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/siswa');

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertSee('2026101');
        $response->assertSee('KULINER 1');
    }

    public function test_admin_can_filter_students(): void
    {
        $u1 = User::factory()->create(['name' => 'Ahmad Dani']);
        Student::create([
            'user_id' => $u1->id,
            'nis' => '2026101',
            'class_name' => 'KULINER 1',
            'status' => 'active',
        ]);

        $u2 = User::factory()->create(['name' => 'Siti Nurhaliza']);
        Student::create([
            'user_id' => $u2->id,
            'nis' => '2026102',
            'class_name' => 'BUSANA 1',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/siswa?search=Ahmad');
        $response->assertOk();
        $response->assertSee('Ahmad Dani');
        $response->assertDontSee('Siti Nurhaliza');

        $responseClass = $this->actingAs($this->admin)->get('/admin/siswa?class=BUSANA 1');
        $responseClass->assertOk();
        $responseClass->assertSee('Siti Nurhaliza');
        $responseClass->assertDontSee('Ahmad Dani');
    }

    public function test_admin_can_view_create_student_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/siswa/create');
        $response->assertOk();
        $response->assertSee('Form Tambah Data Siswa');
    }

    public function test_admin_can_store_new_student_with_user_account(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/siswa', [
            'name' => 'Calon Siswa Baru',
            'nis' => '2026999',
            'class_name' => 'TKJ',
            'whatsapp' => '089988776655',
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/siswa');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Calon Siswa Baru',
            'role' => 'student',
        ]);

        $this->assertDatabaseHas('students', [
            'nis' => '2026999',
            'class_name' => 'TKJ',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_view_student_detail(): void
    {
        $studentUser = User::factory()->create(['name' => 'Rina Nose']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026555',
            'class_name' => 'ANIMASI',
            'whatsapp' => '081234444555',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/siswa/{$student->id}");
        $response->assertOk();
        $response->assertSee('Rina Nose');
        $response->assertSee('2026555');
    }

    public function test_admin_can_view_student_edit_page(): void
    {
        $studentUser = User::factory()->create(['name' => 'Rina Nose']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026555',
            'class_name' => 'ANIMASI',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/siswa/{$student->id}/edit");
        $response->assertOk();
        $response->assertSee('Edit Data Siswa');
        $response->assertSee('Rina Nose');
    }

    public function test_admin_can_update_student_details(): void
    {
        $studentUser = User::factory()->create(['name' => 'Nama Lama']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026777',
            'class_name' => 'KULINER 1',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/siswa/{$student->id}", [
            'name' => 'Nama Baru Diperbarui',
            'nis' => '2026777',
            'class_name' => 'KULINER 2',
            'whatsapp' => '081122334455',
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/siswa');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $studentUser->id,
            'name' => 'Nama Baru Diperbarui',
        ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'class_name' => 'KULINER 2',
            'whatsapp' => '081122334455',
        ]);
    }

    public function test_admin_can_delete_student_and_user_account(): void
    {
        $studentUser = User::factory()->create(['name' => 'Siswa Dihapus']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026888',
            'class_name' => 'BUSANA 2',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/siswa/{$student->id}");

        $response->assertRedirect('/admin/siswa');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
        $this->assertDatabaseMissing('users', ['id' => $studentUser->id]);
    }

    public function test_admin_cannot_delete_student_with_existing_registrations(): void
    {
        $studentUser = User::factory()->create(['name' => 'Siswa Terdaftar']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '2026777',
            'class_name' => 'KULINER 1',
            'status' => 'active',
        ]);

        $period = Period::create([
            'name' => 'TP 2026/2027',
            'academic_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'quota' => 50,
            'is_active' => true,
        ]);

        $registration = Registration::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'extracurricular_id' => $ekskul->id,
            'registration_number' => 'REG-2026-TEST-01',
            'status' => 'submitted',
            'registered_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/siswa/{$student->id}");

        $response->assertRedirect('/admin/siswa');
        $response->assertSessionHas('error', 'Data siswa tidak dapat dihapus karena sudah memiliki riwayat pendaftaran. Silakan nonaktifkan siswa jika tidak ingin digunakan lagi.');

        $this->assertDatabaseHas('students', ['id' => $student->id]);
        $this->assertDatabaseHas('users', ['id' => $studentUser->id]);
        $this->assertDatabaseHas('registrations', ['id' => $registration->id]);
    }
}
