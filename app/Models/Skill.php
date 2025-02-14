<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'skill_id';
    protected $fillable = ['student_id', 'skill_name', 'proficiency_level'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
