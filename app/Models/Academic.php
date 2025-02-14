<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;

    protected $primaryKey = 'academic_id';
    protected $fillable = [
        'student_id',
        'student_number',
        'enrollment_status',
        'year_level',
        'college',
        'program',
        'section',
        'gwa'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
