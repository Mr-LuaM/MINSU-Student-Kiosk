<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [
            [
                'SXXXXX',
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
            'Student ID (Leave blank to auto-generate)',
            'First Name',
            'Middle Name',
            'Last Name',
            'Suffix (Optional)',
            'Birth Date (YYYY-MM-DD)',
            'Gender (Male, Female, Other)',
            'Nationality',
            'Religion',
            'Blood Type (A+, A-, B+, B-, O+, O-, AB+, AB-)',
            'Student Type (Regular, Irregular, Transferee, Foreign)',

            'Student Number',
            'Enrollment Status (Enrolled, Dropped, Graduated)',
            'Year Level',
            'College',
            'Program',
            'Section',
            'GWA (0.00 - 5.00)',

            'Email',
            'Phone Number',
            'Address',
            'Guardian Name',
            'Guardian Contact',
            'Emergency Contact',

            'Skills (comma-separated)',
            'Proficiency Levels (comma-separated, must match skills)',
            'Achievements (comma-separated)',
            'Categories (comma-separated, must match achievements)',
            'Award Dates (comma-separated, YYYY-MM-DD format, must match achievements)',
            'Awarding Bodies (comma-separated, must match achievements)'
        ];
    }

    public function title(): string
    {
        return 'Students Template';
    }
}
