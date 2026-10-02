<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->cascadeOnDelete();
            $table->string('registration_number')->nullable()->unique();
            $table->string('status')->default('submitted')->index(); // submitted, reviewed, accepted, rejected, cancelled
            $table->text('motivation')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'period_id']);
            $table->index(['period_id', 'extracurricular_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
