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
        Schema::table('stages', function (Blueprint $table) {
            // Make all other columns nullable
            $table->string('name')->nullable()->change();
            $table->string('time')->nullable()->change();
            $table->longText('teaching_activities')->nullable()->change();
            $table->longText('learning_activities')->nullable()->change();
            $table->longText('assessment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            // Revert all columns to their original state
            $table->string('name')->nullable(false)->change();
            $table->string('time')->nullable(false)->change();
            $table->longText('teaching_activities')->nullable(false)->change();
            $table->longText('learning_activities')->nullable(false)->change();
            $table->longText('assessment')->nullable(false)->change();
        });
    }
};
