<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new StudentsSheet(),
            new InstructionsSheet(),
        ];
    }
}

class StudentsSheet implements FromArray, WithHeadings, WithTitle, WithStyles
{
    public function array(): array
    {
        return [
            [
                '', // Student ID (Auto-generated)
                'Juan',
                'Dela',
                'Cruz',
                'Jr.',
                '2000-01-01',
                'Male',
                'Filipino',
                'Catholic',
                'O+',
                'Regular',
                'SN123456',
                'Enrolled',
                '3',
                'College of Engineering',
                'BSIT',
                'SEC-1',
                '1.75',
                'juan.delacruz@example.com',
                '09123456789',
                '123 Street, City',
                'Maria Dela Cruz',
                '09198765432',
                '0911222333',
                'Coding, Public Speaking',
                'Expert, Intermediate',
                'Math Olympiad, Robotics Competition',
                'Academic, Technology',
                '2024-05-20, 2023-09-12',
                'National Science Institute, Robotics Club'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            '🟦 Student ID (Leave blank for auto-generation)',
            '🟦 First Name',
            '🟦 Middle Name',
            '🟦 Last Name',
            '🟦 Suffix (Optional)',
            '🟦 Birth Date (YYYY-MM-DD)',
            '🟦 Gender (Male, Female, Other)',
            '🟦 Nationality',
            '🟦 Religion',
            '🟦 Blood Type (A+, A-, B+, B-, O+, O-, AB+, AB-)',
            '🟦 Student Type (Regular, Irregular, Transferee, Foreign)',

            '🟨 Student Number',
            '🟨 Enrollment Status (Enrolled, Dropped, Graduated)',
            '🟨 Year Level',
            '🟨 College',
            '🟨 Program',
            '🟨 Section',
            '🟨 GWA (0.00 - 5.00)',

            '🟩 Email',
            '🟩 Phone Number',
            '🟩 Address',
            '🟩 Guardian Name',
            '🟩 Guardian Contact',
            '🟩 Emergency Contact',

            '🟧 Skills (comma-separated)',
            '🟧 Proficiency Levels (comma-separated, must match skills)',
            '🟧 Achievements (comma-separated)',
            '🟧 Categories (comma-separated, must match achievements)',
            '🟧 Award Dates (comma-separated, YYYY-MM-DD format, must match achievements)',
            '🟧 Awarding Bodies (comma-separated, must match achievements)'
        ];
    }

    public function title(): string
    {
        return 'Students Template';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling (bold, centered, background color)
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'CCCCCC']]
            ],

            // Student Core Information (Light Blue)
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'B3C6E7']]],

            // Academic Information (Light Yellow)
            'L1:R1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FEF6C7']]],

            // Contact Information (Light Green)
            'S1:X1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'DFF3E3']]],

            // Skills & Achievements (Light Orange)
            'Y1:AC1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FED8B1']]],

            // Adjust column widths for readability
            'A' => ['width' => 30],
            'B' => ['width' => 20],
            'C' => ['width' => 20],
            'D' => ['width' => 20],
            'E' => ['width' => 15],
            'F' => ['width' => 15],
            'G' => ['width' => 20],
            'H' => ['width' => 20],
            'I' => ['width' => 20],
            'J' => ['width' => 20],
            'K' => ['width' => 25],
            'L' => ['width' => 20],
            'M' => ['width' => 25],
            'N' => ['width' => 15],
            'O' => ['width' => 25],
            'P' => ['width' => 20],
            'Q' => ['width' => 20],
            'R' => ['width' => 15],
            'S' => ['width' => 30],
            'T' => ['width' => 30],
            'U' => ['width' => 40],
            'V' => ['width' => 30],
            'W' => ['width' => 20],
            'X' => ['width' => 20],
            'Y' => ['width' => 40],
            'Z' => ['width' => 40],
            'AA' => ['width' => 40],
            'AB' => ['width' => 40],
            'AC' => ['width' => 40]
        ];
    }
}

class InstructionsSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        return [
            ['Instructions'],
            ['1. Fill in student details. Ensure `Enrollment Status`, `Blood Type`, and `Gender` match allowed values.'],
            ['2. Multiple Skills/Achievements should be formatted as `Skill1, Skill2` and `Proficiency1, Proficiency2`.'],
            ['3. Achievements should follow `Achievement1, Achievement2` and must match category, date, and awarding body order.'],
            ['4. If `GWA` is invalid, it will default to NULL.'],
            ['5. Student ID can be left blank; it will be generated automatically.']
        ];
    }

    public function title(): string
    {
        return 'Instructions';
    }
}
