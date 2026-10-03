<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Precondition & Unique constraint for registrations(student_id, period_id)
        if (DB::table('registrations')->select('student_id', 'period_id')->groupBy('student_id', 'period_id')->havingRaw('count(*) > 1')->exists()) {
            throw new RuntimeException("Cannot add UNIQUE constraint to registrations: Duplicate (student_id, period_id) records detected.");
        }

        Schema::table('registrations', function (Blueprint $table) {
            $table->unique(['student_id', 'period_id'], 'registrations_student_period_unique');
        });

        // 2. Precondition & Unique constraint for students(nis)
        if (DB::table('students')->whereNotNull('nis')->select('nis')->groupBy('nis')->havingRaw('count(*) > 1')->exists()) {
            throw new RuntimeException("Cannot add UNIQUE constraint to students: Duplicate non-null 'nis' records detected.");
        }

        Schema::table('students', function (Blueprint $table) {
            $table->unique('nis', 'students_nis_unique');
        });

        // 3. Precondition & Unique constraint for recommendations(student_id, period_id)
        if (DB::table('recommendations')->select('student_id', 'period_id')->groupBy('student_id', 'period_id')->havingRaw('count(*) > 1')->exists()) {
            throw new RuntimeException("Cannot add UNIQUE constraint to recommendations: Duplicate (student_id, period_id) records detected.");
        }

        Schema::table('recommendations', function (Blueprint $table) {
            $table->unique(['student_id', 'period_id'], 'recommendations_student_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropUnique('recommendations_student_period_unique');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique('students_nis_unique');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique('registrations_student_period_unique');
        });
    }
};
