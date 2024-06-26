<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlanEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_plan_id',
        'type',
        'evaluation',
        'remarks',
    ];

    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
