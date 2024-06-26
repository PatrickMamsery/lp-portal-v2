<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_plan_id',
        'name',
        'time',
        'teaching_activities',
        'learning_activities',
        'assessment',
    ];

    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
