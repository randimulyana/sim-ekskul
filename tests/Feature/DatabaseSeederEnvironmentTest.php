<?php

namespace Tests\Feature;

use App\Models\Criterion;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Models\User;
use Database\Seeders\DemoDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederEnvironmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_accounts_are_created_in_non_production_environment(): void
    {
        $this->assertEquals('testing', app()->environment());

        $seeder = new DemoDataSeeder();
        $seeder->run();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@smkn3payakumbuh.sch.id',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'andi.saputra@smkn3payakumbuh.sch.id',
            'role' => 'student',
        ]);

        $this->assertDatabaseCount('extracurriculars', 12);
        $this->assertDatabaseCount('criteria', 5);
        $this->assertDatabaseCount('extracurricular_criterion_mappings', 60);
    }

    public function test_demo_accounts_are_not_created_in_production_environment(): void
    {
        // Simulate production environment
        $this->app['env'] = 'production';
        $this->assertTrue($this->app->environment('production'));

        $seeder = new DemoDataSeeder();
        $seeder->run();

        // Demo user accounts must NOT be created
        $this->assertDatabaseMissing('users', [
            'email' => 'admin@smkn3payakumbuh.sch.id',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'andi.saputra@smkn3payakumbuh.sch.id',
        ]);

        // Essential research configuration must STILL be provisioned
        $this->assertDatabaseCount('extracurriculars', 12);
        $this->assertDatabaseCount('criteria', 5);
        $this->assertDatabaseCount('extracurricular_criterion_mappings', 60);
    }
}
