<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'school_id',
        'grade_id',
        'stream_id',
        'subject_id',
        'topic_id',
        'subtopic_id',
        'competence_id',

        'logo',
        'show_logo',
    ];

    protected $casts = [
        'show_logo' => 'boolean',
    ];

    protected $appends = [
        'logo_url',
    ];

    protected function logoUrl(): Attribute
    {
        return Attribute::get(static function (mixed $value, array $attributes): ?string {
            return isset($attributes['logo']) ? asset('images/' . $attributes['logo']) : null;
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function subtopic()
    {
        return $this->belongsTo(Subtopic::class);
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function evaluations()
    {
        return $this->hasMany(LessonPlanEvaluation::class);
    }
}
