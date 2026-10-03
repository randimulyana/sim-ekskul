<?php

namespace Tests\Feature;

use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Recommendation;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseConstraintTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test A: registrations unique constraint (student_id, period_id)
     */
    public function test_registrations_prevents_duplicate_student_and_period(): void
    {
        $period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'is_active' => true,
        ]);

        $user = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026001',
            'status' => 'active',
        ]);

        $ekskul1 = Extracurricular::create([
            'name' => 'PASKIBRAKA',
            'slug' => 'paskibraka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        $ekskul2 = Extracurricular::create([
            'name' => 'PRAMUKA',
            'slug' => 'pramuka',
            'category' => 'Organisasi',
            'is_active' => true,
        ]);

        // First registration insert succeeds
        Registration::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'extracurricular_id' => $ekskul1->id,
            'registration_number' => 'REG-2026-001-AAAA',
            'status' => 'submitted',
        ]);

        // Second registration insert for same student and period fails at database level
        $this->expectException(UniqueConstraintViolationException::class);

        Registration::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'extracurricular_id' => $ekskul2->id,
            'registration_number' => 'REG-2026-001-BBBB',
            'status' => 'submitted',
        ]);
    }

    /**
     * Test B: students NIS unique constraint (non-null duplicate rejected)
     */
    public function test_students_prevents_duplicate_non_null_nis(): void
    {
        $user1 = User::factory()->create(['role' => 'student']);
        Student::create([
            'user_id' => $user1->id,
            'nis' => '2026999',
            'status' => 'active',
        ]);

        $user2 = User::factory()->create(['role' => 'student']);

        $this->expectException(UniqueConstraintViolationException::class);

        Student::create([
            'user_id' => $user2->id,
            'nis' => '2026999',
            'status' => 'active',
        ]);
    }

    /**
     * Test C: students allows multiple NULL NIS values (e.g. self-registration)
     */
    public function test_students_allows_multiple_null_nis(): void
    {
        $user1 = User::factory()->create(['role' => 'student']);
        $student1 = Student::create([
            'user_id' => $user1->id,
            'nis' => null,
            'status' => 'active',
        ]);

        $user2 = User::factory()->create(['role' => 'student']);
        $student2 = Student::create([
            'user_id' => $user2->id,
            'nis' => null,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('students', ['id' => $student1->id, 'nis' => null]);
        $this->assertDatabaseHas('students', ['id' => $student2->id, 'nis' => null]);
        $this->assertEquals(2, Student::whereNull('nis')->count());
    }

    /**
     * Test D: recommendations unique constraint (student_id, period_id)
     */
    public function test_recommendations_prevents_duplicate_student_and_period(): void
    {
        $period = Period::create([
            'name' => 'Tahun Pelajaran 2026/2027',
            'is_active' => true,
        ]);

        $user = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $user->id,
            'nis' => '2026002',
            'status' => 'active',
        ]);

        // First recommendation insert succeeds
        Recommendation::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'method_name' => 'SAW',
            'method_version' => '1.0',
            'generated_at' => now(),
        ]);

        // Second recommendation insert for same student and period fails at database level
        $this->expectException(UniqueConstraintViolationException::class);

        Recommendation::create([
            'student_id' => $student->id,
            'period_id' => $period->id,
            'method_name' => 'SAW',
            'method_version' => '1.0',
            'generated_at' => now(),
        ]);
    }
}
