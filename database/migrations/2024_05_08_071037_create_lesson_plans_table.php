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
        if (!Schema::hasTable('lesson_plans')) {
            Schema::create('lesson_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
                $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();
                $table->foreignId('stream_id')->constrained('streams')->cascadeOnDelete();

                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->foreignId('teacher_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
                $table->foreignId('subtopic_id')->constrained('subtopics')->cascadeOnDelete();
                $table->foreignId('competence_id')->constrained('competences')->cascadeOnDelete();

                $table->string('intro_time');
                $table->longText('intro_teacher_activities');
                $table->longText('intro_student_activities');
                $table->longText('intro_assessment');

                $table->string('new_knowledge_time');
                $table->longText('new_knowledge_teacher_activities');
                $table->longText('new_knowledge_student_activities');
                $table->longText('new_knowledge_assessment');

                $table->string('reinforcement_time');
                $table->longText('reinforcement_teacher_activities');
                $table->longText('reinforcement_student_activities');
                $table->longText('reinforcement_assessment');

                $table->string('reflection_time');
                $table->longText('reflection_teacher_activities');
                $table->longText('reflection_student_activities');
                $table->longText('reflection_assessment');

                $table->string('conclusion_time');
                $table->longText('conclusion_teacher_activities');
                $table->longText('conclusion_student_activities');
                $table->longText('conclusion_assessment');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
