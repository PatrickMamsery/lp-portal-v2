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
        Schema::table('lesson_plan_evaluations', function (Blueprint $table) {
            $table->longText('remarks')->nullable()->after('evaluation');

            $table->dropColumn('type');
        });

        Schema::table('lesson_plan_evaluations', function (Blueprint $table) {
            $table->enum('type', ['student', 'teacher', 'remarks'])->after('lesson_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_plan_evaluations', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};
