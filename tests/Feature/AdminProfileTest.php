<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Pengguna',
            'email' => 'admin.pengguna@smkn3payakumbuh.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_profile_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/profil');

        $response->assertOk();
        $response->assertSee('Profil Administrator');
        $response->assertSee('Admin Pengguna');
        $response->assertSee('admin.pengguna@smkn3payakumbuh.sch.id');
    }

    public function test_admin_can_update_profile_info(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil', [
            'name' => 'Admin Pengguna Terupdate',
            'email' => 'admin.baru@smkn3payakumbuh.sch.id',
        ]);

        $response->assertRedirect('/admin/profil');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'Admin Pengguna Terupdate',
            'email' => 'admin.baru@smkn3payakumbuh.sch.id',
        ]);
    }

    public function test_admin_can_update_password_with_valid_current_password(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil/password', [
            'current_password' => 'password123',
            'password' => 'PasswordBaru123#',
            'password_confirmation' => 'PasswordBaru123#',
        ]);

        $response->assertRedirect('/admin/profil');
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('PasswordBaru123#', $this->admin->fresh()->password));
    }

    public function test_admin_password_update_fails_with_invalid_current_password(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/profil/password', [
            'current_password' => 'salah_password',
            'password' => 'PasswordBaru123#',
            'password_confirmation' => 'PasswordBaru123#',
        ]);

        $response->assertSessionHasErrors(['current_password']);
    }

    public function test_admin_profile_update_validation_fails_for_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'lain@smkn3payakumbuh.sch.id',
        ]);

        $response = $this->actingAs($this->admin)->put('/admin/profil', [
            'name' => 'Admin Test',
            'email' => 'lain@smkn3payakumbuh.sch.id',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
