<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::with(['academics', 'contact', 'skills', 'achievements'])->get();
    }

    public function map($student): array
    {
        return [
            'student_id' => $student->student_id,
            'first_name' => $student->first_name,
            'middle_name' => $student->middle_name,
            'last_name' => $student->last_name,
            'suffix' => $student->suffix,
            'birth_date' => $student->birth_date ?? 'N/A',
            'gender' => $student->gender ?? 'Other',
            'nationality' => $student->nationality ?? 'N/A',
            'religion' => $student->religion ?? 'N/A',
            'blood_type' => $student->blood_type ?? 'Unknown',
            'student_type' => $student->student_type ?? 'Regular',
            'student_number' => optional($student->academics)->student_number ?? 'N/A',
            'enrollment_status' => optional($student->academics)->enrollment_status ?? 'Enrolled',
            'year_level' => optional($student->academics)->year_level ?? 1,
            'college' => optional($student->academics)->college ?? 'N/A',
            'program' => optional($student->academics)->program ?? 'N/A',
            'section' => optional($student->academics)->section ?? 'N/A',
            'gwa' => optional($student->academics)->gwa ?? 'N/A',
            'email' => optional($student->contact)->email ?? 'N/A',
            'phone_number' => optional($student->contact)->phone_number ?? 'N/A',
            'address' => optional($student->contact)->address ?? 'N/A',
            'guardian_name' => optional($student->contact)->guardian_name ?? 'N/A',
            'guardian_contact' => optional($student->contact)->guardian_contact ?? 'N/A',
            'emergency_contact' => optional($student->contact)->emergency_contact ?? 'N/A',
            'skills' => $student->skills->pluck('skill_name')->implode(', ') ?? 'None',
            'proficiency_levels' => $student->skills->pluck('proficiency_level')->implode(', ') ?? 'None',
            'achievements' => $student->achievements->pluck('achievement_name')->implode(', ') ?? 'None',
            'categories' => $student->achievements->pluck('category')->implode(', ') ?? 'None',
            'award_dates' => $student->achievements->pluck('award_date')->implode(', ') ?? 'None',
            'awarding_bodies' => $student->achievements->pluck('awarding_body')->implode(', ') ?? 'None',
        ];
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Suffix',
            'Birth Date',
            'Gender',
            'Nationality',
            'Religion',
            'Blood Type',
            'Student Type',
            'Student Number',
            'Enrollment Status',
            'Year Level',
            'College',
            'Program',
            'Section',
            'GWA',
            'Email',
            'Phone Number',
            'Address',
            'Guardian Name',
            'Guardian Contact',
            'Emergency Contact',
            'Skills (comma-separated)',
            'Proficiency Levels (comma-separated)',
            'Achievements (comma-separated)',
            'Categories (comma-separated)',
            'Award Dates (comma-separated)',
            'Awarding Bodies (comma-separated)'
        ];
    }
}
