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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['INTRODUCTION', 'DEVELOPING NEW KNOWLEDGE', 'REINFORCEMENT', 'REFLECTION', 'CONCLUSION']);
            $table->string('time');
            $table->longText('teaching_activities');
            $table->longText('learning_activities');
            $table->longText('assessment');
            $table->foreignId('lesson_plan_id')->constrained('lesson_plans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
