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
        Schema::table('criteria', function (Blueprint $table) {
            if (! Schema::hasColumn('criteria', 'status')) {
                $table->string('status')->default('needs_validation')->after('weight');
            }
        });

        Schema::table('question_options', function (Blueprint $table) {
            if (! Schema::hasColumn('question_options', 'criterion_value_id')) {
                $table->foreignId('criterion_value_id')
                    ->nullable()
                    ->after('question_id')
                    ->constrained('criterion_values')
                    ->nullOnDelete();
            }
        });

        Schema::table('extracurricular_criterion_mappings', function (Blueprint $table) {
            if (! Schema::hasColumn('extracurricular_criterion_mappings', 'status')) {
                $table->string('status')->default('needs_validation')->after('value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular_criterion_mappings', function (Blueprint $table) {
            if (Schema::hasColumn('extracurricular_criterion_mappings', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('question_options', function (Blueprint $table) {
            if (Schema::hasColumn('question_options', 'criterion_value_id')) {
                $table->dropForeign(['criterion_value_id']);
                $table->dropColumn('criterion_value_id');
            }
        });

        Schema::table('criteria', function (Blueprint $table) {
            if (Schema::hasColumn('criteria', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
