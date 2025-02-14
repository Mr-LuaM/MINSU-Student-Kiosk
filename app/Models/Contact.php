<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $primaryKey = 'contact_id';
    protected $fillable = [
        'student_id',
        'email',
        'phone_number',
        'address',
        'guardian_name',
        'guardian_contact',
        'emergency_contact'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
