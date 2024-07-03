<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'rfid_tag',
        'dob',
        'gender',
        'school_id'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
