<?php

namespace Tests\Feature\Student;

use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;
    protected Student $student;
    protected Period $activePeriod;
    protected Extracurricular $ekskul1;
    protected Extracurricular $ekskul2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->studentUser = User::factory()->create([
            'role' => 'student',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@smkn3payakumbuh.sch.id',
        ]);

        $this->student = Student::create([
            'user_id' => $this->studentUser->id,
            'nis' => '2026111',
            'class_name' => 'KULINER 1',
            'whatsapp' => '081234567890',
            'status' => 'active',
        ]);

        $this->activePeriod = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'academic_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $this->ekskul1 = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'description' => 'Pasukan Pengibar Bendera Pusaka',
            'quota' => 60,
            'is_active' => true,
        ]);

        $this->ekskul2 = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'description' => 'Gerakan Pramuka Gudep SMKN 3',
            'quota' => 80,
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_to_login_from_registration_routes(): void
    {
        $this->get('/siswa/pendaftaran')->assertRedirect('/login');
        $this->post('/siswa/pendaftaran', [])->assertRedirect('/login');
        $this->get('/siswa/pendaftaran/sukses')->assertRedirect('/login');
        $this->get('/siswa/riwayat')->assertRedirect('/login');
    }

    public function test_student_can_view_registration_form(): void
    {
        $response = $this->actingAs($this->studentUser)->get('/siswa/pendaftaran');

        $response->assertOk();
        $response->assertSee('Formulir Pendaftaran Ekstrakurikuler');
        $response->assertSee($this->activePeriod->name);
        $response->assertSee('Budi Santoso');
        $response->assertSee('2026111');
        $response->assertSee('KULINER 1');
    }

    public function test_student_can_view_registration_form_with_preselected_ekskul(): void
    {
        $response = $this->actingAs($this->studentUser)->get('/siswa/pendaftaran?ekskul_id=' . $this->ekskul2->id);

        $response->assertOk();
        $response->assertSee('PRAMUKA');
    }

    public function test_student_can_submit_registration_successfully(): void
    {
        $response = $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => $this->ekskul1->id,
            'motivation' => 'Saya bertekad melatih kedisiplinan dan rasa tanggung jawab.',
            'agreement' => '1',
        ]);

        $response->assertRedirect('/siswa/pendaftaran/sukses');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registrations', [
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $this->ekskul1->id,
            'status' => 'submitted',
            'motivation' => 'Saya bertekad melatih kedisiplinan dan rasa tanggung jawab.',
        ]);

        $reg = Registration::where('student_id', $this->student->id)->first();
        $this->assertNotNull($reg);
        $this->assertStringStartsWith('REG-', $reg->registration_number);
    }

    public function test_registration_requires_extracurricular_id_and_agreement(): void
    {
        $response = $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => '',
            'motivation' => 'Tanpa ekskul',
        ]);

        $response->assertSessionHasErrors(['extracurricular_id', 'agreement']);
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_duplicate_registration_within_same_period_is_prevented(): void
    {
        // First registration
        $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => $this->ekskul1->id,
            'motivation' => 'Pendaftaran pertama',
            'agreement' => '1',
        ])->assertRedirect('/siswa/pendaftaran/sukses');

        $this->assertDatabaseCount('registrations', 1);

        // Attempt second registration in the same period
        $response = $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => $this->ekskul2->id,
            'motivation' => 'Mencoba mendaftar lagi',
            'agreement' => '1',
        ]);

        $response->assertRedirect('/siswa/pendaftaran/sukses');
        $response->assertSessionHas('info');

        // Still only 1 registration exists
        $this->assertDatabaseCount('registrations', 1);
        $this->assertDatabaseHas('registrations', [
            'student_id' => $this->student->id,
            'extracurricular_id' => $this->ekskul1->id,
        ]);
    }

    public function test_student_can_view_registration_success_page(): void
    {
        $reg = Registration::create([
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $this->ekskul1->id,
            'registration_number' => 'REG-2026-001-TEST',
            'status' => 'submitted',
            'registered_at' => now(),
        ]);

        session(['latest_registration_id' => $reg->id]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/pendaftaran/sukses');

        $response->assertOk();
        $response->assertSee('REG-2026-001-TEST');
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('Budi Santoso');
    }

    public function test_student_can_view_registration_history(): void
    {
        Registration::create([
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $this->ekskul1->id,
            'registration_number' => 'REG-2026-001-HIST',
            'status' => 'submitted',
            'registered_at' => now(),
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/riwayat');

        $response->assertOk();
        $response->assertSee('Riwayat Pendaftaran');
        $response->assertSee('REG-2026-001-HIST');
        $response->assertSee('PASKIBRAKA');
    }

    public function test_student_isolation_only_shows_own_history(): void
    {
        // Registration for current student
        Registration::create([
            'student_id' => $this->student->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $this->ekskul1->id,
            'registration_number' => 'REG-MY-OWN-123',
            'status' => 'submitted',
            'registered_at' => now(),
        ]);

        // Registration for another student
        $otherUser = User::factory()->create(['role' => 'student', 'name' => 'Siswa Lain']);
        $otherStudent = Student::create([
            'user_id' => $otherUser->id,
            'nis' => '2026999',
            'class_name' => 'BUSANA 1',
        ]);
        Registration::create([
            'student_id' => $otherStudent->id,
            'period_id' => $this->activePeriod->id,
            'extracurricular_id' => $this->ekskul2->id,
            'registration_number' => 'REG-OTHER-456',
            'status' => 'submitted',
            'registered_at' => now(),
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/riwayat');

        $response->assertOk();
        $response->assertSee('REG-MY-OWN-123');
        $response->assertDontSee('REG-OTHER-456');
    }

    public function test_cannot_register_if_no_active_period(): void
    {
        $this->activePeriod->update(['is_active' => false]);

        $response = $this->actingAs($this->studentUser)->post('/siswa/pendaftaran', [
            'extracurricular_id' => $this->ekskul1->id,
            'motivation' => 'Mencoba mendaftar tanpa periode',
            'agreement' => '1',
        ]);

        $response->assertRedirect('/siswa/pendaftaran');
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('registrations', 0);
    }
}
