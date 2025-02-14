<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birth_date',
        'gender',
        'nationality',
        'religion',
        'blood_type',
        'student_type'
    ];

    // Relationships
    public function contact()
    {
        return $this->hasOne(Contact::class, 'student_id');
    }

    public function academics()
    {
        return $this->hasOne(Academic::class, 'student_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'student_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'student_id');
    }
}
