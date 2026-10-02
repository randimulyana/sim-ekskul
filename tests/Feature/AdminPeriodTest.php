<?php

namespace Tests\Feature;

use App\Models\Period;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPeriodTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Periode',
            'email' => 'admin.periode@smkn3payakumbuh.sch.id',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_period_settings_page(): void
    {
        Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'school_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/pengaturan');

        $response->assertOk();
        $response->assertSee('Pengaturan Periode Pendaftaran');
        $response->assertSee('Tahun Pelajaran 2026/2027');
    }

    public function test_admin_can_store_new_period(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pengaturan', [
            'name' => 'Periode Semester Genap 2026/2027',
            'school_year' => '2026/2027',
            'start_date' => '2027-01-10',
            'end_date' => '2027-02-10',
            'is_active' => true,
            'description' => 'Pendaftaran semester genap siswa kelas X.',
        ]);

        $response->assertRedirect('/admin/pengaturan');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('periods', [
            'name' => 'Periode Semester Genap 2026/2027',
            'school_year' => '2026/2027',
            'is_active' => 1,
        ]);
    }

    public function test_storing_active_period_deactivates_other_periods(): void
    {
        $oldPeriod = Period::create([
            'name' => 'Periode Lama',
            'school_year' => '2025/2026',
            'start_date' => '2025-08-01',
            'end_date' => '2025-09-30',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin)->post('/admin/pengaturan', [
            'name' => 'Periode Baru',
            'school_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('periods', [
            'id' => $oldPeriod->id,
            'is_active' => 0,
        ]);

        $this->assertDatabaseHas('periods', [
            'name' => 'Periode Baru',
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_update_existing_period(): void
    {
        $period = Period::create([
            'name' => 'Periode Edit',
            'school_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/pengaturan/{$period->id}", [
            'name' => 'Periode Edit Diperpanjang',
            'school_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-10-15',
            'is_active' => true,
        ]);

        $response->assertRedirect('/admin/pengaturan');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('periods', [
            'id' => $period->id,
            'name' => 'Periode Edit Diperpanjang',
        ]);
        $this->assertEquals('2026-10-15', $period->fresh()->end_date->format('Y-m-d'));
    }

    public function test_admin_can_toggle_period_status(): void
    {
        $period = Period::create([
            'name' => 'Periode Buka Tutup',
            'school_year' => '2026/2027',
            'start_date' => '2026-08-01',
            'end_date' => '2026-09-30',
            'is_active' => true,
        ]);

        // Close it
        $response = $this->actingAs($this->admin)->patch("/admin/pengaturan/{$period->id}/toggle");
        $response->assertRedirect('/admin/pengaturan');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('periods', [
            'id' => $period->id,
            'is_active' => 0,
        ]);

        // Re-open it
        $response2 = $this->actingAs($this->admin)->patch("/admin/pengaturan/{$period->id}/toggle");
        $response2->assertRedirect('/admin/pengaturan');

        $this->assertDatabaseHas('periods', [
            'id' => $period->id,
            'is_active' => 1,
        ]);
    }

    public function test_store_period_validation_fails_when_end_date_before_start_date(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/pengaturan', [
            'name' => 'Periode Salah Tanggal',
            'school_year' => '2026/2027',
            'start_date' => '2026-10-01',
            'end_date' => '2026-09-01', // earlier than start date
        ]);

        $response->assertSessionHasErrors(['end_date']);
    }
}
