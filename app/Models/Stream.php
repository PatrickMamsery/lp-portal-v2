<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_id',
        'school_id',
        'year',
    ];

    public function grade() {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }
}
