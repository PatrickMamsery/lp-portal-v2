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
        Schema::table('lesson_plans', function (Blueprint $table) {
            $table->dropColumn('intro_time');
            $table->dropColumn('intro_teacher_activities');
            $table->dropColumn('intro_student_activities');
            $table->dropColumn('intro_assessment');

            $table->dropColumn('new_knowledge_time');
            $table->dropColumn('new_knowledge_teacher_activities');
            $table->dropColumn('new_knowledge_student_activities');
            $table->dropColumn('new_knowledge_assessment');

            $table->dropColumn('reinforcement_time');
            $table->dropColumn('reinforcement_teacher_activities');
            $table->dropColumn('reinforcement_student_activities');
            $table->dropColumn('reinforcement_assessment');

            $table->dropColumn('reflection_time');
            $table->dropColumn('reflection_teacher_activities');
            $table->dropColumn('reflection_student_activities');
            $table->dropColumn('reflection_assessment');

            $table->dropColumn('conclusion_time');
            $table->dropColumn('conclusion_teacher_activities');
            $table->dropColumn('conclusion_student_activities');
            $table->dropColumn('conclusion_assessment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_plans', function (Blueprint $table) {
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
        });
    }
};
