<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Student::with(['academics', 'contact', 'skills', 'achievements'])->get();
    }

    public function map($student): array
    {
        return [
            $student->student_id ?? '',
            $student->first_name ?? '',
            $student->middle_name ?? '',
            $student->last_name ?? '',
            $student->suffix ?? '',
            $student->birth_date ?? '',
            $student->gender ?? '',
            $student->nationality ?? '',
            $student->religion ?? '',
            $student->blood_type ?? '',
            $student->student_type ?? '',

            // Academic Data
            optional($student->academics)->student_number ?? '',
            optional($student->academics)->enrollment_status ?? '',
            optional($student->academics)->year_level ?? '',
            optional($student->academics)->college ?? '',
            optional($student->academics)->program ?? '',
            optional($student->academics)->section ?? '',
            optional($student->academics)->gwa ?? '',

            // Contact Information
            optional($student->contact)->email ?? '',
            optional($student->contact)->phone_number ?? '',
            optional($student->contact)->address ?? '',
            optional($student->contact)->guardian_name ?? '',
            optional($student->contact)->guardian_contact ?? '',
            optional($student->contact)->emergency_contact ?? '',

            // Skills & Achievements
            $student->skills->pluck('skill_name')->implode(', ') ?: '',
            $student->skills->pluck('proficiency_level')->implode(', ') ?: '',
            $student->achievements->pluck('achievement_name')->implode(', ') ?: '',
            $student->achievements->pluck('category')->implode(', ') ?: '',
            $student->achievements->pluck('award_date')->map(fn($date) => $date ? date('Y-m-d', strtotime($date)) : '')->implode(', ') ?: '',
            $student->achievements->pluck('awarding_body')->implode(', ') ?: '',
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

            'Skills',
            'Proficiency Levels',
            'Achievements',
            'Categories',
            'Award Dates',
            'Awarding Bodies',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'CCCCCC']]
            ],

            // Student Information (Light Blue)
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'B3C6E7']]],

            // Academic Information (Light Yellow)
            'L1:R1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FEF6C7']]],

            // Contact Information (Light Green)
            'S1:X1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'DFF3E3']]],

            // Skills & Achievements (Light Orange)
            'Y1:AC1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FED8B1']]],
        ];
    }
}
