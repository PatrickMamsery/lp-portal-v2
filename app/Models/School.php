<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'name',
        'slug',
        'region',
        'district',
        'ward',
        'level_id'
    ];

    public function level() {
        return $this->belongsTo(EducationLevel::class, 'level_id');
    }

    /**
     * Get the members of the school. Note that the second argument is the pivot table name.
     *
     * The members referred to here are the users who are members of the school.
     * Separate from "members" who don't interact with the system.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'school_users', 'school_id', 'user_id');
    }

    /**
     * Get the admins of the school. Note that the second argument is the pivot table name.
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'school_admins', 'school_id', 'admin_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    public function subtopics()
    {
        return $this->hasMany(Subtopic::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }
}
