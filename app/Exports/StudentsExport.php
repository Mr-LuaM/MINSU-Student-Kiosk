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
            $student->student_id,
            $student->first_name,
            $student->middle_name ?? 'N/A',
            $student->last_name,
            $student->suffix ?? 'N/A',
            $student->birth_date ?? 'N/A',
            $student->gender ?? 'Other',
            $student->nationality ?? 'N/A',
            $student->religion ?? 'N/A',
            $student->blood_type ?? 'Unknown',
            $student->student_type ?? 'Regular',

            // Academic Data
            optional($student->academics)->student_number ?? 'N/A',
            optional($student->academics)->enrollment_status ?? 'Enrolled',
            optional($student->academics)->year_level ?? 1,
            optional($student->academics)->college ?? 'N/A',
            optional($student->academics)->program ?? 'N/A',
            optional($student->academics)->section ?? 'N/A',
            optional($student->academics)->gwa ?? 'N/A',

            // Contact Information
            optional($student->contact)->email ?? 'N/A',
            optional($student->contact)->phone_number ?? 'N/A',
            optional($student->contact)->address ?? 'N/A',
            optional($student->contact)->guardian_name ?? 'N/A',
            optional($student->contact)->guardian_contact ?? 'N/A',
            optional($student->contact)->emergency_contact ?? 'N/A',

            // Skills & Achievements
            $student->skills->pluck('skill_name')->implode(', ') ?: 'None',
            $student->skills->pluck('proficiency_level')->implode(', ') ?: 'None',
            $student->achievements->pluck('achievement_name')->implode(', ') ?: 'None',
            $student->achievements->pluck('category')->implode(', ') ?: 'None',
            $student->achievements->pluck('award_date')
                ->map(fn($date) => $date && strtotime($date) ? date('Y-m-d', strtotime($date)) : 'N/A')
                ->implode(', ') ?: 'None',
            $student->achievements->pluck('awarding_body')->implode(', ') ?: 'None',
        ];
    }

    public function headings(): array
    {
        return [
            '🟦 Student ID',
            '🟦 First Name',
            '🟦 Middle Name',
            '🟦 Last Name',
            '🟦 Suffix',
            '🟦 Birth Date',
            '🟦 Gender',
            '🟦 Nationality',
            '🟦 Religion',
            '🟦 Blood Type',
            '🟦 Student Type',

            '🟨 Student Number',
            '🟨 Enrollment Status',
            '🟨 Year Level',
            '🟨 College',
            '🟨 Program',
            '🟨 Section',
            '🟨 GWA',

            '🟩 Email',
            '🟩 Phone Number',
            '🟩 Address',
            '🟩 Guardian Name',
            '🟩 Guardian Contact',
            '🟩 Emergency Contact',

            '🟧 Skills (comma-separated)',
            '🟧 Proficiency Levels (comma-separated)',
            '🟧 Achievements (comma-separated)',
            '🟧 Categories (comma-separated)',
            '🟧 Award Dates (comma-separated, YYYY-MM-DD)',
            '🟧 Awarding Bodies (comma-separated)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],

            // Student Core Info (Light Blue)
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'B3C6E7']]],

            // Academic Info (Light Yellow)
            'L1:R1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FEF6C7']]],

            // Contact Info (Light Green)
            'S1:X1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'DFF3E3']]],

            // Skills & Achievements (Light Orange)
            'Y1:AC1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FED8B1']]],

            // Auto-adjust column widths for readability
            // 'A' => ['width' => 15],
            // 'B' => ['width' => 20],
            // 'C' => ['width' => 20],
            // 'D' => ['width' => 20],
            // 'E' => ['width' => 15],
            // 'F' => ['width' => 15],
            // 'G' => ['width' => 20],
            // 'H' => ['width' => 20],
            // 'I' => ['width' => 20],
            // 'J' => ['width' => 20],
            // 'K' => ['width' => 25],
            // 'L' => ['width' => 20],
            // 'M' => ['width' => 25],
            // 'N' => ['width' => 15],
            // 'O' => ['width' => 25],
            // 'P' => ['width' => 20],
            // 'Q' => ['width' => 20],
            // 'R' => ['width' => 15],
            // 'S' => ['width' => 30],
            // 'T' => ['width' => 30],
            // 'U' => ['width' => 40],
            // 'V' => ['width' => 30],
            // 'W' => ['width' => 20],
            // 'X' => ['width' => 20],
            // 'Y' => ['width' => 40],
            // 'Z' => ['width' => 40],
            // 'AA' => ['width' => 40],
            // 'AB' => ['width' => 40],
            // 'AC' => ['width' => 40]
        ];
    }
}
