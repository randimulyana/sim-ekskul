<?php

namespace Tests\Feature;

use App\Models\Extracurricular;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminExtracurricularCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Ekskul',
            'email' => 'admin.ekskul@smkn3payakumbuh.sch.id',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_extracurricular_index_page(): void
    {
        Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/ekstrakurikuler');

        $response->assertOk();
        $response->assertSee('Data Ekstrakurikuler');
        $response->assertSee('PASKIBRAKA');
        $response->assertSee('Organisasi');
    }

    public function test_admin_can_filter_extracurriculars_by_search_category_and_status(): void
    {
        Extracurricular::create([
            'name' => 'SILAT TRADISI',
            'slug' => 'silat-tradisi',
            'category' => 'Bela Diri',
            'is_active' => true,
        ]);

        Extracurricular::create([
            'name' => 'JAPANESE CLUB',
            'slug' => 'japanese-club',
            'category' => 'Akademik',
            'is_active' => false,
        ]);

        // Search filter
        $searchRes = $this->actingAs($this->admin)->get('/admin/ekstrakurikuler?search=SILAT');
        $searchRes->assertOk();
        $searchRes->assertSee('SILAT TRADISI');
        $searchRes->assertDontSee('JAPANESE CLUB');

        // Category filter
        $catRes = $this->actingAs($this->admin)->get('/admin/ekstrakurikuler?category=Akademik');
        $catRes->assertOk();
        $catRes->assertSee('JAPANESE CLUB');
        $catRes->assertDontSee('SILAT TRADISI');

        // Status filter (active)
        $statusRes = $this->actingAs($this->admin)->get('/admin/ekstrakurikuler?status=aktif');
        $statusRes->assertOk();
        $statusRes->assertSee('SILAT TRADISI');
        $statusRes->assertDontSee('JAPANESE CLUB');
    }

    public function test_admin_can_view_create_extracurricular_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/ekstrakurikuler/create');

        $response->assertOk();
        $response->assertSee('Tambah Ekstrakurikuler');
    }

    public function test_admin_can_store_new_extracurricular(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/ekstrakurikuler', [
            'name' => 'ROBOTIK & IOT',
            'category' => 'Teknologi',
            'description' => 'Kegiatan perakitan robotika dan otomatisasi SMK.',
            'schedule' => 'Sabtu, 09.00 - 12.00',
            'location' => 'Lab Komputer 2',
            'coach_name' => 'Budi Santoso, S.T.',
            'quota' => 30,
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/ekstrakurikuler');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('extracurriculars', [
            'name' => 'ROBOTIK & IOT',
            'slug' => 'robotik-iot',
            'category' => 'Teknologi',
            'is_active' => 1,
        ]);
    }

    public function test_store_extracurricular_validation_fails_for_duplicate_name(): void
    {
        Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/ekstrakurikuler', [
            'name' => 'PRAMUKA',
            'category' => 'Organisasi',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_admin_can_view_extracurricular_detail(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'PADUAN SUARA',
            'slug' => 'paduan-suara',
            'category' => 'Seni & Budaya',
            'description' => 'Ekskul seni olah vokal sekolah.',
            'schedule' => 'Jumat 14.00',
            'location' => 'Ruang Musik',
            'coach_name' => 'Siti Nurhaliza',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/ekstrakurikuler/{$ekskul->id}");

        $response->assertOk();
        $response->assertSee('PADUAN SUARA');
        $response->assertSee('Ruang Musik');
        $response->assertSee('Siti Nurhaliza');
    }

    public function test_admin_can_view_edit_extracurricular_page(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'TAHFIDZ',
            'slug' => 'tahfidz',
            'category' => 'Keagamaan',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/ekstrakurikuler/{$ekskul->id}/edit");

        $response->assertOk();
        $response->assertSee('Edit Ekstrakurikuler');
        $response->assertSee('TAHFIDZ');
    }

    public function test_admin_can_update_extracurricular(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'ENGLISH CLUB',
            'slug' => 'english-club',
            'category' => 'Akademik',
            'coach_name' => 'Mr. John',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/ekstrakurikuler/{$ekskul->id}", [
            'name' => 'ENGLISH & PUBLIC SPEAKING CLUB',
            'category' => 'Akademik',
            'coach_name' => 'Mr. John Doe',
            'status' => 'aktif',
        ]);

        $response->assertRedirect('/admin/ekstrakurikuler');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('extracurriculars', [
            'id' => $ekskul->id,
            'name' => 'ENGLISH & PUBLIC SPEAKING CLUB',
            'slug' => 'english-public-speaking-club',
            'coach_name' => 'Mr. John Doe',
        ]);
    }

    public function test_admin_can_delete_extracurricular(): void
    {
        $ekskul = Extracurricular::create([
            'name' => 'EKSKUL SEMENTARA',
            'slug' => 'ekskul-sementara',
            'category' => 'Lainnya',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/ekstrakurikuler/{$ekskul->id}");

        $response->assertRedirect('/admin/ekstrakurikuler');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('extracurriculars', [
            'id' => $ekskul->id,
        ]);
    }
}
