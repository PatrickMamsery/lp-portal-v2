<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_id',
        'main_objective',
        'school_id',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subtopics()
    {
        return $this->hasMany(Subtopic::class);
    }

    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
