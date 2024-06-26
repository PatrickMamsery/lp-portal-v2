<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'teacher_id',
        'stream_id',
        'school_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
