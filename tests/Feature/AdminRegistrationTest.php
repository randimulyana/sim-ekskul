<?php

namespace Tests\Feature;

use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Period $period;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Pendaftaran',
            'email' => 'admin.pendaftaran@smkn3payakumbuh.sch.id',
            'role' => 'admin',
        ]);

        $this->period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_registration_index(): void
    {
        $user = User::factory()->create(['name' => 'Budi Santoso']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026100',
            'class_name' => 'TKJ',
            'whatsapp' => '08123456789',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        Registration::create([
            'student_id' => $student->id,
            'extracurricular_id' => $ekskul->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/pendaftaran');

        $response->assertOk();
        $response->assertSee('Data Pendaftaran');
        $response->assertSee('Budi Santoso');
        $response->assertSee('PASKIBRAKA');
    }

    public function test_admin_can_filter_registrations_by_status_ekskul_and_class(): void
    {
        $user1 = User::factory()->create(['name' => 'Ahmad Dani']);
        $student1 = Student::create([
            'user_id' => $user1->id,
            'nis' => '2026101',
            'class_name' => 'ANIMASI',
        ]);

        $user2 = User::factory()->create(['name' => 'Citra Kirana']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'nis' => '2026102',
            'class_name' => 'KULINER 1',
        ]);

        $ekskul1 = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
        ]);

        $ekskul2 = Extracurricular::create([
            'name' => 'ENGLISH CLUB',
            'slug' => 'english-club',
            'category' => 'Akademik',
        ]);

        Registration::create([
            'student_id' => $student1->id,
            'extracurricular_id' => $ekskul1->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
        ]);

        Registration::create([
            'student_id' => $student2->id,
            'extracurricular_id' => $ekskul2->id,
            'period_id' => $this->period->id,
            'status' => 'accepted',
        ]);

        // Filter by status
        $statusRes = $this->actingAs($this->admin)->get('/admin/pendaftaran?status=accepted');
        $statusRes->assertOk();
        $statusRes->assertSee('Citra Kirana');
        $statusRes->assertDontSee('Ahmad Dani');

        // Filter by ekskul
        $ekskulRes = $this->actingAs($this->admin)->get("/admin/pendaftaran?ekskul={$ekskul1->id}");
        $ekskulRes->assertOk();
        $ekskulRes->assertSee('Ahmad Dani');
        $ekskulRes->assertDontSee('Citra Kirana');

        // Filter by class
        $classRes = $this->actingAs($this->admin)->get('/admin/pendaftaran?class=ANIMASI');
        $classRes->assertOk();
        $classRes->assertSee('Ahmad Dani');
        $classRes->assertDontSee('Citra Kirana');
    }

    public function test_admin_can_view_registration_detail(): void
    {
        $user = User::factory()->create(['name' => 'Dewi Sartika']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026103',
            'class_name' => 'BUSANA 1',
            'whatsapp' => '08987654321',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'MODELLING',
            'slug' => 'modelling',
            'category' => 'Seni & Budaya',
        ]);

        $reg = Registration::create([
            'student_id' => $student->id,
            'extracurricular_id' => $ekskul->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
            'notes' => 'Catatan pendaftar awal',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/pendaftaran/{$reg->id}");

        $response->assertOk();
        $response->assertSee('Detail Pendaftaran Siswa');
        $response->assertSee('Dewi Sartika');
        $response->assertSee('MODELLING');
    }

    public function test_admin_can_update_registration_status_to_accepted_with_notes(): void
    {
        $user = User::factory()->create(['name' => 'Eko Prasetyo']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026104',
            'class_name' => 'TKJ',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'SILAT TRADISI',
            'slug' => 'silat-tradisi',
            'category' => 'Bela Diri',
        ]);

        $reg = Registration::create([
            'student_id' => $student->id,
            'extracurricular_id' => $ekskul->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/pendaftaran/{$reg->id}/status", [
            'status' => 'accepted',
            'notes' => 'Memenuhi syarat fisik dan minat yang tinggi.',
        ]);

        $response->assertRedirect("/admin/pendaftaran/{$reg->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'id' => $reg->id,
            'status' => 'accepted',
            'notes' => 'Memenuhi syarat fisik dan minat yang tinggi.',
        ]);
    }

    public function test_admin_can_update_registration_status_to_rejected(): void
    {
        $user = User::factory()->create(['name' => 'Fajar Sidik']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026105',
            'class_name' => 'PERHOTELAN 2',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'MARCHING BAND',
            'slug' => 'marching-band',
            'category' => 'Seni & Budaya',
        ]);

        $reg = Registration::create([
            'student_id' => $student->id,
            'extracurricular_id' => $ekskul->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/pendaftaran/{$reg->id}/status", [
            'status' => 'rejected',
            'notes' => 'Kuota tim terompet sudah penuh.',
        ]);

        $response->assertRedirect("/admin/pendaftaran/{$reg->id}");
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'id' => $reg->id,
            'status' => 'rejected',
            'notes' => 'Kuota tim terompet sudah penuh.',
        ]);
    }

    public function test_update_registration_status_validation_fails_for_invalid_status(): void
    {
        $user = User::factory()->create(['name' => 'Gita Gutawa']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026106',
            'class_name' => 'KULINER 2',
        ]);

        $ekskul = Extracurricular::create([
            'name' => 'PADUAN SUARA',
            'slug' => 'paduan-suara-2',
            'category' => 'Seni & Budaya',
        ]);

        $reg = Registration::create([
            'student_id' => $student->id,
            'extracurricular_id' => $ekskul->id,
            'period_id' => $this->period->id,
            'status' => 'submitted',
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/pendaftaran/{$reg->id}/status", [
            'status' => 'invalid_status_value',
        ]);

        $response->assertSessionHasErrors(['status']);
    }
}
