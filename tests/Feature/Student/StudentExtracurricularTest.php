<?php

namespace Tests\Feature\Student;

use App\Models\Extracurricular;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentExtracurricularTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->studentUser = User::factory()->create(['role' => 'student']);
    }

    public function test_student_can_view_active_extracurriculars_catalog(): void
    {
        $activeEkskul = Extracurricular::create([
            'name' => 'PRAMUKA SMKN 3',
            'slug' => 'pramuka-smkn-3',
            'category' => 'Organisasi',
            'description' => 'Kegiatan kepanduan dan kemandirian siswa.',
            'is_active' => true,
        ]);

        $inactiveEkskul = Extracurricular::create([
            'name' => 'EKSKUL DITUTUP',
            'slug' => 'ekskul-ditutup',
            'category' => 'Khusus',
            'description' => 'Ekskul yang sedang tidak aktif.',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/ekstrakurikuler');

        $response->assertOk();
        $response->assertSee('PRAMUKA SMKN 3');
        $response->assertDontSee('EKSKUL DITUTUP');
    }

    public function test_student_can_search_extracurriculars(): void
    {
        Extracurricular::create([
            'name' => 'SILAT TRADISI MINANG',
            'slug' => 'silat-tradisi-minang',
            'category' => 'Bela Diri',
            'description' => 'Seni bela diri silek tradisional.',
            'is_active' => true,
        ]);

        Extracurricular::create([
            'name' => 'PADUAN SUARA',
            'slug' => 'paduan-suara',
            'category' => 'Seni & Budaya',
            'description' => 'Pelatihan vokal dan harmoni paduan suara.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/ekstrakurikuler?search=SILAT');

        $response->assertOk();
        $response->assertSee('SILAT TRADISI MINANG');
        $response->assertDontSee('PADUAN SUARA');
    }

    public function test_student_can_filter_extracurriculars_by_category(): void
    {
        Extracurricular::create([
            'name' => 'ENGLISH CLUB',
            'slug' => 'english-club',
            'category' => 'Akademik',
            'description' => 'English conversation and debate.',
            'is_active' => true,
        ]);

        Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'description' => 'Pasukan pengibar bendera pusaka.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->studentUser)->get('/siswa/ekstrakurikuler?category=Akademik');

        $response->assertOk();
        $response->assertSee('ENGLISH CLUB');
        $response->assertDontSee('PASKIBRAKA');
    }

    public function test_student_can_view_active_extracurricular_detail(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'MARCHING BAND BAHANA',
            'slug' => 'marching-band-bahana',
            'category' => 'Seni & Budaya',
            'description' => 'Korps musik perkusi dan tiup kebanggaan sekolah.',
            'schedule_info' => 'Sabtu, 08.00 - 11.00 WIB',
            'location_info' => 'Lapangan Upacara',
            'coach_name' => 'Bapak Pembina Musik',
            'quota' => 50,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->studentUser)->get("/siswa/ekstrakurikuler/{$ekskul->id}");

        $response->assertOk();
        $response->assertSee('MARCHING BAND BAHANA');
        $response->assertSee('Korps musik perkusi dan tiup kebanggaan sekolah.');
        $response->assertSee('Sabtu, 08.00 - 11.00 WIB');
        $response->assertSee('Lapangan Upacara');
        $response->assertSee('Bapak Pembina Musik');
    }

    public function test_viewing_inactive_or_nonexistent_extracurricular_returns_404(): void
    {
        $inactive = Extracurricular::create([
            'name' => 'Ekskul Nonaktif',
            'slug' => 'ekskul-nonaktif',
            'category' => 'Umum',
            'is_active' => false,
        ]);

        $this->actingAs($this->studentUser)->get("/siswa/ekstrakurikuler/{$inactive->id}")->assertNotFound();
        $this->actingAs($this->studentUser)->get('/siswa/ekstrakurikuler/99999')->assertNotFound();
    }
}
