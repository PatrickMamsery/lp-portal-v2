<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'topic_id',
        'school_id',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
