<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $primaryKey = 'achievement_id';
    protected $fillable = [
        'student_id',
        'achievement_name',
        'category',
        'award_date',
        'awarding_body'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
