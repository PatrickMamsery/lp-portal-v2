<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'education_level_id',
        'school_id',
        'year',
    ];

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class, 'education_level_id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }
}
